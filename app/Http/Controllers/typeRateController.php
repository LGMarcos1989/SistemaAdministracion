<?php

namespace App\Http\Controllers;

use App\Models\typeRateModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class typeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $impuestos = typeRateModel::select('id', 'name', 'value') ->get();
        return view ('admin.typerate.index', compact('impuestos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.typerate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string',
            'value' => 'required|integer|min:0',
        ]);

        typeRateModel::create([
            'name' => $request->name,
            'value' => $request->value,
        ]);
 
        return redirect () -> route('admin.impuestos.index')->with('flash', [
            'title' => 'Registro creado con éxito',
            'icon' =>'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(typeRateModel $typeRateModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(typeRateModel $impuesto)
    {
       return view ('admin.typerate.update', compact('impuesto')
       );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, typeRateModel $impuesto)
    {
         $request->validate([
            'name'=> 'required|string',
            'value' => 'required|integer|min:0',
        ]);

        // Llamamos a la variable que hemos almacenado para actualizarla

        $impuesto->update([
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return redirect () -> route('admin.impuestos.index')->with('flash', [
            'title' => 'Registro actualizado',
            'icon' =>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(typeRateModel $impuesto)
    {
        $impuesto->delete();

        return redirect()->route('admin.impuestos.index')->with('flash',[
            'title' => 'Registro eliminado con éxito',
            'icon' =>'success'
        ]);
    }
}
