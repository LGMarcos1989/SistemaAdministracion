<?php

namespace App\Http\Controllers;

use App\Models\UserTypeModel;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = UserTypeModel::paginate(10);
        return view('admin.usertype.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usertype.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        userTypeModel::create([
            'name' => $request->name,

        ]);

        return redirect()->route('admin.usertype.index')->with('flash',[
            'title' => 'Registro creado con éxito',
            'icon' =>'success'
        ]);
    }

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserTypeModel $usertype)
    {
        return view ('admin.usertype.update', compact('usertype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserTypeModel $usertype)
    {
         $request->validate([
            'name' => 'required|string'
        ]);

        $usertype ->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.usertype.index')->with('flash',[
            'title' => 'Registro actualizado con éxito',
            'icon' =>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTypeModel $usertype)
    {
        $usertype->delete();

        return redirect()->route('admin.usertype.index')->with('flash',[
            'title' => 'Registro eliminado con éxito',
            'icon' =>'success'
        ]);
    }
}
