<?php

namespace App\Http\Controllers;

use App\Models\cancelledInvoiceModel;
use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\typeRateModel;
use Illuminate\Http\Request;
use App\Http\Controllers\cancelledInvoiceController;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InvoiceModel::query();

        if ($request->has('search')) {
            $search = trim(strtolower($request->search));

            $query->with('client')->where(function($query) use ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
                $query->orWhereHas('client', function($q) use ($search) {
                    $q->where('bussiness_name', 'like', "%{$search}%");
                });
            })->select('id','invoice_number','total','status', 'client_id')->paginate(10);

        }

         if ($request->has('status') && $request->status != '') {
             $query->where('status', $request->status);
         }

       
        $facturas = $query->latest()->paginate(10);
        $facturasAnuladas = cancelledInvoiceModel::with('invoice.client')->latest()->paginate(10);
        $totalFacturas = InvoiceModel::count('id');
        $pagadasCount = InvoiceModel::where('status', 'Pagada')->count();
        $pendientesCount=InvoiceModel::where('status', 'Pendiente')->count();
        $anuladasCount=InvoiceModel::where('status', 'Anulada')->count();
        return view('admin.invoice.index',compact('facturas','facturasAnuladas','totalFacturas','pagadasCount','pendientesCount','anuladasCount'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Consultar base de datos y hacer factura consecutiva y si no iniciarla desde cero
        //Traemos la ultima factura que fue registrada
        $ultimaFactura = InvoiceModel::latest()->first();
        //Si hay factura FACT-00001
        if($ultimaFactura){
            $partes = explode ('-',$ultimaFactura->invoice_number);
            $ultimoNumero = intval($partes[1]);
            $proximoNumero = $ultimoNumero + 1;
        }else{
            $proximoNumero = 1;
        }

        //Esto es lo que nos da el numero FACT-000001
        $propuestaFactura = 'FACT-' . str_pad($proximoNumero, 6, '0',STR_PAD_LEFT);

        $clientes=ClientModel::select('id','bussiness_name' , 'cif')->get();
        if($clientes->count()<=0){
             return redirect()->route('admin.clientes.index')->with('flash', [
            'title' => 'No existen clientes creados, debe registrarlos primero',
            'icon' =>'warning'
        ]);
        }
        
        $codigos =typeRateModel::select('id','name', 'value')->get();
           if($codigos->count()<=0){
             return redirect()->route('admin.impuestos.index')->with('flash', [
            'title' => 'No existen codigos impositivos creados, debe registrarlos primero',
            'icon' =>'warning'
        ]);
        }

        return view('admin.invoice.create' , compact('clientes', 'codigos', 'propuestaFactura'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number'=> 'nullable|string',
            'invoice_date' => 'required|date',
            'description' => 'nullable|string',
            'tax_base' => 'required',
            'type_rate_id'=> 'required|integer',
            'total'=> 'required|string',
            'status'=> 'required|string',
            'note'=> 'nullable|sometimes|string',
            'client_id'=> 'required|integer',
        ]);

       
        InvoiceModel::create($request->all());

        return redirect()->route('admin.facturacion.index')->with('flash', [
            'title' => 'Registro actualizado',
            'icon' =>'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    
    public function downloadPDF(InvoiceModel $facturacion){
        $facturacion->load(['client', 'type_rate']);
        
        $taxAmount = 0;
        $taxRate = 0;
        
        if ($facturacion->type_rate) {
            $taxRate = $facturacion->type_rate->value;
            $taxAmount = ($facturacion->tax_base) * ($taxRate / 100);
        }

        $info = [
            'bussiness_name' => 'Loren Admin S.L.',
            'cif' => 'B47318899',
            'adress' => 'C/ Nueva, 9',
            'phone' => '669405070',
            'email' => 'admin@lorenadmin.com'
        ];

        
        $data = [
            'info'=>$info,
            'invoice' => $facturacion,
            'taxAmount' => $taxAmount,
            'taxRate' => $taxRate,
            'subtotal' => $facturacion->tax_base,
            'total' => $facturacion->total,
        ];
        
        $pdf = Pdf::loadView('admin.invoice.pdf', $data);
        
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('Factura_' . $facturacion->number . '.pdf');
    }


    public function show(InvoiceModel $facturacion)
    {
    
        $facturacion->load(['client','type_rate']);
        return view('admin.invoice.show',compact('facturacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceModel $facturacion)
    {
      
        return view('admin.invoice.update', compact('facturacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceModel $facturacion)
    {
       $request->validate([
            'status'=> 'required|string',
            'note'=> 'nullable|sometimes|string',
        ]);

       
        $facturacion->update([
        'status' => $request->status,
        'note' => $request->note,
    ]);

        if($request->status === 'Anulada'){
          cancelledInvoiceModel::create([
                'invoice_id' => $facturacion->id,
                'total' =>'-'. $facturacion->total, 
           ]);
        }

        return redirect()->route('admin.facturacion.index')->with('flash', [
            'title' => 'Registro actualizado',
            'icon' =>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceModel $facturacion)
    {
        //
    }
}
