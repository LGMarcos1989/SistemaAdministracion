<?php

namespace App\Http\Controllers;

use App\Models\PersonModel;
use App\Models\User;
use App\Models\UserTypeModel;
use Faker\Provider\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $totalUsuarios = PersonModel::count('id');
        $activosCount = PersonModel::where('isActive', '1')->count();
        $inactivosCount=PersonModel::where('isActive', '0')->count();
        $administradoresCount = PersonModel::whereHas('user', function($q){
            $q->whereHas('userType', function($q2){
                $q2->where('name','Administrador');
            });
        })->count();
        $consultoresCount = PersonModel::whereHas('user', function($q){
            $q->whereHas('userType', function($q2){
                $q2->where('name','Consultor');
            });
        })->count();

        $query = PersonModel::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                ->orWhere('lastname', 'like', "%{$search}%")
                ->orWhere('dni', 'like', "%{$search}%")
                ->orWhereHas('user', function($q2) use ($search) {
                    $q2->where('email', 'like', "%{$search}%");
                });
            });
        }

        if($request->has('status') && $request->status ==='activo'){
                        $query->orWhere('isActive',1);
                    }
                     elseif($request->has('status') && $request->status ==='inactivo'){
                        $query->orWhere('isActive',0);
                    }



       $person =  $query->latest()->paginate(10);
        return view('admin.staff.index', compact('person','totalUsuarios','activosCount','inactivosCount','administradoresCount','consultoresCount' ));
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
            'isActive' => 1,
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
            'password'=>'nullable|sometimes|string',
            'password_verify'=>'nullable|sometimes|string',
            'user_type_id' => 'integer|required',
            'fullname' => 'string|required',
            'lastname' => 'string|nullable',
            'dni' => 'string|required',
            'city' => 'string|nullable',
            'phone' => 'string|nullable',
            'isActive' => 'required|boolean',
        
        ], [
            'email.email' =>'El email debe tener forma de ejemplo@hotmail.com',
            ]);

        $data = [
            'email' => $request->email,
            'user_type_id' => $request->user_type_id
        ];
        
        if ($request->password ===  $request->password_verify) {
            $data['password'] = bcrypt($request->password);
        } else {
            return redirect()->back()->with('flash', [
               'icon' => 'warning', 
               'title' => 'Las contraseñas no coinciden', 
            ]);
        }

       $user = $staff->user()->update($data);
        

         $staff->update([
            'fullname' => $request-> fullname,
            'lastname' => $request-> lastname,
            'dni' => $request-> dni,
            'city' => $request-> city,
            'phone' => $request-> phone,
            'isActive' => $request->isActive,
                    
        ]);

      

        return redirect()->route('admin.staff.index')->with('flash',[
             'title' => 'Registro actualizado con éxito',
            'icon' =>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonModel $staff)
    {
         $staff->update([
            'isActive'=> 0
         ]);
            
         

        return redirect()->route('admin.staff.index')->with('flash',[
            'title' => 'Registro deshabilitado con éxito',
            'icon' =>'success'
        ]);
    }
}
                