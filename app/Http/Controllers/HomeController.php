<?php

namespace App\Http\Controllers;

use App\Models\InvoiceModel;
use App\Models\ClientModel;
use App\Models\PersonModel;
use App\Models\cancelledInvoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalFacturas = InvoiceModel::count();
        $totalAmount = InvoiceModel::sum('total') / 100;
        
        $pagadasCount = InvoiceModel::where('status', 'Pagada')->count();
        $pendientesCount = InvoiceModel::where('status', 'Pendiente')->count();
        $anuladasCount = InvoiceModel::where('status', 'Anulada')->count();
        
        $pagadasAmount = InvoiceModel::where('status', 'Pagada')->sum('total') / 100;
        $pendientesAmount = InvoiceModel::where('status', 'Pendiente')->sum('total') / 100;
        $anuladasAmount = cancelledInvoiceModel::sum('total') / 100;
        
        $conversionRate = $totalFacturas > 0 ? round(($pagadasCount / $totalFacturas) * 100, 1) : 0;
        
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;
        
        $currentMonthAmount = InvoiceModel::whereMonth('invoice_date', $currentMonth)
            ->whereYear('invoice_date', $currentYear)
            ->sum('total') / 100;
            
        $lastMonthAmount = InvoiceModel::whereMonth('invoice_date', $lastMonth)
            ->whereYear('invoice_date', $lastMonthYear)
            ->sum('total') / 100;
            
        $amountGrowth = $lastMonthAmount > 0 
            ? round((($currentMonthAmount - $lastMonthAmount) / $lastMonthAmount) * 100, 1)
            : ($currentMonthAmount > 0 ? 100 : 0);
            
        $currentMonthCount = InvoiceModel::whereMonth('invoice_date', $currentMonth)
            ->whereYear('invoice_date', $currentYear)
            ->count();
            
        $lastMonthCount = InvoiceModel::whereMonth('invoice_date', $lastMonth)
            ->whereYear('invoice_date', $lastMonthYear)
            ->count();
            
        $invoicesGrowth = $lastMonthCount > 0 
            ? round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1)
            : ($currentMonthCount > 0 ? 100 : 0);
        
        $totalClientes = ClientModel::count();
        $activosCount = ClientModel::where('status', 'Abierto')->count();
        $inactivosCount = ClientModel::where('status', 'Cerrado')->count();
        $nuevosEsteMes = ClientModel::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $totalStaff = PersonModel::count();
        $activeStaff = PersonModel::where('isActive', true)->count();
        $inactiveStaff = PersonModel::where('isActive', false)->count();
        
        $monthlyLabels = [];
        $monthlyData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->locale('es')->shortMonthName;
            $monthlyLabels[] = $monthName;
            
            $total = InvoiceModel::whereMonth('invoice_date', $month->month)
                ->whereYear('invoice_date', $month->year)
                ->sum('total') / 100;
                
            $monthlyData[] = round($total, 2);
        }
        
        $recentInvoices = InvoiceModel::with('client')
            ->latest('invoice_date')
            ->limit(5)
            ->get();
        
        $topClients = ClientModel::withSum('invoices', 'total')
            ->having('invoices_sum_total', '>', 0)
            ->orderBy('invoices_sum_total', 'desc')
            ->limit(5)
            ->get();
        
        $maxTotal = $topClients->first()?->invoices_sum_total ?? 1;
        foreach ($topClients as $client) {
            $client->percentage = round(($client->invoices_sum_total / $maxTotal) * 100, 1);
            $client->total_invoiced = $client->invoices_sum_total;
        }
        
        $recentStaff = PersonModel::with('user')
            ->latest('id')
            ->limit(5)
            ->get();
        
        return view('admin.home.index', [
            'totalFacturas' => $totalFacturas,
            'totalAmount' => $totalAmount,
            'pagadasCount' => $pagadasCount,
            'pendientesCount' => $pendientesCount,
            'anuladasCount' => $anuladasCount,
            'pagadasAmount' => $pagadasAmount,
            'pendientesAmount' => $pendientesAmount,
            'anuladasAmount' => $anuladasAmount,
            'conversionRate' => $conversionRate,
            'amountGrowth' => $amountGrowth,
            'invoicesGrowth' => $invoicesGrowth,
            'totalClientes' => $totalClientes,
            'activosCount' => $activosCount,
            'inactivosCount' => $inactivosCount,
            'nuevosEsteMes' => $nuevosEsteMes,
            'totalStaff' => $totalStaff,
            'activeStaff' => $activeStaff,
            'inactiveStaff' => $inactiveStaff,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'recentInvoices' => $recentInvoices,
            'topClients' => $topClients,
            'recentStaff' => $recentStaff,
        ]);
    }
}