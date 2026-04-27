<?php

namespace App\Http\Controllers;

use App\Models\PersonModel;
use App\Models\User;
use App\Models\UserTypeModel;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $person = PersonModel::with('user.userType')->paginate(10);
        return view('admin.staff.index', compact('person'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_types = UserTypeModel::select('id','name')->get();
        return view('admin.staff.create', compact('user_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([  
            'email'=> 'email|required',
            'password'=>'string|required',
            'user_type_id' => 'integer|required',
            'fullname' => 'string|required',
            'lastname' => 'string|nullable',
            'dni' => 'string|required',
            'city' => 'string|nullable',
            'phone' => 'string|nullable',
            
        ]);

        $user = User::create([
            'email' => $request->email,
            'password'=> bcrypt($request->password),
            'user_type_id' => $request->user_type_id,
        ]);

        PersonModel::create([
            'fullname' => $request-> fullname,
            'lastname' => $request-> lastname,
            'dni' => $request-> dni,
            'city' => $request-> city,
            'phone' => $request-> phone,
            'user_id' => $user-> id,
        ]);

        return redirect()->route('admin.staff.index')->with('flash',[
             'title' => 'Registro actualizado',
            'icon' =>'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonModel $staff)
    {
        return view ('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonModel $staff)
    {
         $user_types = UserTypeModel::select('id','name')->get();
         return view('admin.staff.update', compact('staff', 'user_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonModel $staff)
    {
         $request->validate([
            'email'=> 'email|required',
            'password'=>'string|required',
            'user_type_id' => 'integer|required',
            'fullname' => 'string|required',
            'lastname' => 'string|nullable',
            'dni' => 'string|required',
            'city' => 'string|nullable',
            'phone' => 'string|nullable',
            
        ]);

       $user = $staff->user()->update([
            'email' => $request->email,
            'password'=> bcrypt($request->password),
            'user_type_id' => $request->user_type_id,
        ]);
        

         $user = $staff->user()->update([
            'fullname' => $request-> fullname,
            'lastname' => $request-> lastname,
            'dni' => $request-> dni,
            'city' => $request-> city,
            'phone' => $request-> phone,
            'user_id' => $user,
        ]);

      

        return redirect()->route('admin.staff.index')->with('flash',[
             'title' => 'Registro actualizado con éxito',
            'icon' =>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonModel $personModel)
    {
        //
    }
}
