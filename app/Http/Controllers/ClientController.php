<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filtros de búsqueda
        $query = ClientModel::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('cif', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Obtener clientes paginados
        $clientes = $query->latest()->paginate(10);

        // Calcular estadísticas
        $totalClientes = ClientModel::count();
        $activosCount = ClientModel::where('status', 'Activo')->count();
        $inactivosCount = ClientModel::where('status', 'Inactivo')->count();

        // Calcular NUEVOS ESTE MES con Carbon
        $nuevosEsteMes = ClientModel::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return view('admin.clients.index', compact(
            'clientes',
            'totalClientes',
            'activosCount',
            'inactivosCount',
            'nuevosEsteMes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bussiness_name' => 'required|string',
            'cif' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

       // dd( $request->all());
        //dd( $request->bussiness_name);
        //dd( $request->cif);
        //dd( $request->address);
        //dd( $request->phone);
        //dd( $request-> email);
       

        ClientModel::create([
            'bussiness_name' => $request->bussiness_name,
            'cif' => $request->cif,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return Redirect()->route('admin.clientes.index')->with('flash', [
            'title' => 'Registro actualizado',
            'icon' =>'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientModel $clientModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientModel $cliente)
    {
       
       return view ('admin.clients.update', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientModel $cliente)
    {
       // dd($request->all());
        $request->validate([
            'bussiness_name'=>'required|string',
            'cif'=>'required|string',
            'address'=>'nullable|sometimes|string',
            'phone' => 'nullable|sometimes|string',
            'email' => 'nullable|sometimes|string',
            'status' =>'required|string' 

        ]);
    
        //dd($request->all());
        $cliente->update([
           'bussiness_name'=>$request->bussiness_name,
            'cif'=>$request->cif,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'status'=>$request->status,
        ]);

        return redirect()->route('admin.clientes.index')->with('flash', [
            'title' => 'Registro actualizado',
            'icon' =>'success'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientModel $clientModel)
    {
        //
    }
}
