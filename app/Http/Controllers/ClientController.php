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
                $q->where('bussiness_name', 'like', "%{$search}%")
                    ->orWhere('cif', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
   
            });
        }


        if($request->has('status') && $request->status ==='Abierto'){
                        $query->orWhere('status',$request->status);
                    }
                     elseif($request->has('status') && $request->status ==='Cerrado'){
                        $query->orWhere('status',$request->status);
                    }

        // Obtener clientes paginados
        $clientes = $query->latest()->paginate(10);

        // Calcular estadísticas
        $totalClientes = ClientModel::count();
        $abiertoCount = ClientModel::where('status', 'Abierto')->count();
        $cerradoCount = ClientModel::where('status', 'Cerrado')->count();

        // Calcular NUEVOS ESTE MES con Carbon
        $nuevosEsteMes = ClientModel::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return view('admin.clients.index', compact(
            'clientes',
            'totalClientes',
            'abiertoCount',
            'cerradoCount',
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
            'cif' => 'required|string|min:9|max:9',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|sometimes|email',
        ], [
            'cif.min' =>'El cif debe tener 9 caracteres',
            'cif.max' =>'El cif debe tener 9 caracteres',
            'email.email' =>'El email debe tener forma de ejemplo@hotmail.com'
        ]);
       

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
            'cif'=>'required|string|min:9|max:9',
            'address'=>'nullable|sometimes|string',
            'phone' => 'nullable|sometimes|string',
            'email' => 'nullable|sometimes|email',
            'status' =>'required|string' 

        ],[
            'cif.min' =>'El cif debe tener 9 caracteres',
            'cif.max' =>'El cif debe tener 9 caracteres',
            'email.email' =>'El email debe tener forma de ejemplo@hotmail.com'
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
    public function destroy(Request $request, ClientModel $cliente)
    {
       $cliente->delete();

        return redirect()->route('admin.clientes.index')->with('flash',[
            'title' => 'Registro eliminado con éxito',
            'icon' =>'success'
        ]);
    }
}
