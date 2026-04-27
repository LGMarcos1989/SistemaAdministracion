<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\typeRateModel;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = InvoiceModel::select( 'id','invoice_number','total','status', 'client_id')->get();
        $totalFacturas = InvoiceModel::count('id');
        $activosCount=0;
        $inactivosCount=0;
        $Anuladas=0;
        return view('admin.invoice.index',compact('facturas','totalFacturas','activosCount','inactivosCount','Anuladas'));

        
        // Filtros de búsqueda
        // $query = InvoiceModel::query();

        // if ($request->has('search') && $request->search != '') {
        //     $search = $request->search;
        //     $query->where(function ($q) use ($search) {
        //         $q->where('fullname', 'like', "%{$search}%")
        //             ->orWhere('lastname', 'like', "%{$search}%")
        //             ->orWhere('cif', 'like', "%{$search}%")
        //             ->orWhere('email', 'like', "%{$search}%");
        //     });
        // }

        // if ($request->has('status') && $request->status != '') {
        //     $query->where('status', $request->status);
        // }

        // // Obtener clientes paginados
        // $clientes = $query->latest()->paginate(10);

        // // Calcular estadísticas
        // $pagadas = ClientModel::count();
        // $activosCount = ClientModel::where('status', 'Activo')->count();
        // $inactivosCount = ClientModel::where('status', 'Inactivo')->count();

        
    

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
        // $ultimaFactura = InvoiceModel::latest()->first();
        // if ($ultimaFactura) {
        //     $numero = intval(substr($ultimaFactura->numero_factura, 4)) + 1;
        // } else {
        //     $numero = 1;
        // }
        // $numeroFactura = 'FAC-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        // InvoiceModel::create([
        //     'numero_factura' => $numeroFactura,
        // ]);
        $request->validate([
            'invoice_number'=> 'nullable|string',
            'invoice_date' => 'required|date',
            'description' => 'nullable|string',
            'tax_base' => 'required',
            'type_rate_id'=> 'required|integer',
            'total'=> 'required|string',
            'status'=> 'required|string',
            'nota'=> 'nullable|sometimes|string',
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
            'nota'=> 'nullable|sometimes|string',
        ]);



       // InvoiceModel::create($request->all());
       $facturacion->update([
            'status'=>$request->status,
            'note'=>$request->note,
       ]);

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
