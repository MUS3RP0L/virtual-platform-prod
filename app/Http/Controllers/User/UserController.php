<?php

namespace Muserpol\Http\Controllers\User;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Util;

use Muserpol\User;
use Muserpol\Module;
use Muserpol\Role;

use DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      if (Auth::user()->can('manage')) {
            return view('users.index');
        }else {
            return redirect('/');
        }
    }
    public function Data()
    {
        $users = User::select(['id','username', 'first_name', 'last_name', 'phone','status'])->where('id', '>', 1);
        return Datatables::of($users)
            ->addColumn('name', function ($user) { return Util::ucw($user->first_name) . ' ' . Util::ucw($user->last_name); })
            ->addColumn('module', function ($user) { return $user->roles()->first()->module()->first()->name; })
            ->addColumn('role', function ($user): string { 
                 $roles_list=[];
                 foreach ($user->roles as $role) {
                     $roles_list[]=$role->name;
                 }
                return implode(",",$roles_list);
            })
            ->addColumn('status', function ($user) { return $user->status == 'active' ? 'Activo' : 'Inactivo'; })
            ->addColumn('action', function ($user) { return  $user->status == "active" ?
                '<div class="btn-group" style="margin:-3px 0;">
                    <a href="user/'.$user->id.'/edit "class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;</a>
                    <a href="" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</a>
                    <ul class="dropdown-menu">
                        <li><a href="user/block/'.$user->id.' " style="padding:3px 5px;"><i class="glyphicon glyphicon-ban-circle"></i> Bloquear</a></li>
                    </ul>
                </div>' :
                '<div class="btn-group" style="margin:-3px 0;">
                    <a href="user/'.$user->id.'/edit " class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;</a>
                    <a href="" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</a>
                    <ul class="dropdown-menu">
                        <li><a href="user/unblock/'.$user->id.' " style="padding:3px 5px;"><i class="glyphicon glyphicon-ok-circle"></i> Activar</a></li>
                    </ul>
                </div>';})->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getViewModel()
    {
        $modules = Module::all();
        $list_modules = array('' => '');
        foreach ($modules as $item) {
             $list_modules[$item->id]=$item->name;
        }

        return [
            'list_modules' => $list_modules,
        ];
    }

    public function getRole(Request $request)
    {

        if($request->ajax())
        {
            $allRolesOfModule = Role::moduleidIs($request->module_id)->get();
            
            $usersHasRoles = DB::table('roles')
                        ->select('name','module_id')
                        ->join('role_user', 'roles.id', '=', 'role_user.role_id')
                        ->where('role_user.user_id','=',$request->user_id)
                        ->get();
            $data = [

                'user_roles' => $usersHasRoles,
                'list_roles' => $allRolesOfModule
            ];
            return response()->json($data);
        }
    }

    public function create()
    {
        if (Auth::user()->can('manage')) {

            return view('users.create', self::getViewModel());

        }else{

            return redirect('/');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($user)
    {
 
        $data = [

            'user' => $user,
            'list_roles' => ''
        ];

        $data = array_merge($data, self::getViewModel());

        return View('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $user)
    {

        return $this->save($request, $user);
    }

    public function save($request, $user = false)
    {
        if ($user) {

            $rules = [

                'last_name' => 'required|min:3',
                'first_name' => 'required|min:3',
                'phone' => 'required|min:8',
                'username' => 'required|unique:users,username,'.$user->id,

            ];
        }
        else {

            $rules = [

                'last_name' => 'required|min:3',
                'first_name' => 'required|min:3',
                'phone' => 'required|min:8',
                'username' => 'required|unique:users,username',
                'password' => 'required|min:6|confirmed',
                'role' => 'required'

            ];
        }

        $messages = [

            'first_name.required' => 'El campo nombre requerido',
            'first_name.min' => 'El mínimo de caracteres permitidos en nombre es 3',

            'last_name.required' => 'El campo apellidos es requerido',
            'last_name.min' => 'El mínimo de caracteres permitidos en apellido es 3',

            'phone.required' => 'El campo teléfono es requerido',
            'phone.min' => 'El mínimo de caracteres permitidos en teléfono de usuario es 7',


            'username.required' => 'El campo nombre de usuario requerido',
            'username.min' => 'El mínimo de caracteres permitidos en nombre de usuario es 5',
            'username.unique' => 'El nombre de usuario ya existe',

            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'El mínimo de caracteres permitidos en contraseña es 6',
            'password.confirmed' => 'Las contraseñas no coinciden',

            'role.required' => 'El campo tipo de usuario es requerido'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect($user ? 'user/'.$user->id.'/edit' : 'user/create')
            ->withErrors($validator)
            ->withInput();
        }
        else{

            if ($user) {

                $message = "Usuario Actualizado con éxito";

            }else {

                $user = new User();
                $message = "Usuario Creado con éxito";
            }

            $user->first_name = trim($request->first_name);
            $user->last_name = trim($request->last_name);
            $user->phone = trim($request->phone);
            $user->username = trim($request->username);
            if($request->password){$user->password = bcrypt(trim($request->password));}
                $user->save();

            if($request->role){

                $user->roles()->sync($request->role);
            }
    
            Session::flash('message', $message);
        }

        return redirect('user');
    }

    public function Block($user)
    {
        $user->status = "inactive";
        $user->save();
        $message = "Usuario Bloqueado";
        Session::flash('message', $message);
        return redirect('user');
    }

    public function Unblock($user)
    {
        $user->status = "active";
        $user->save();
        $message = "Usuario Activado";
        Session::flash('message', $message);
        return redirect('user');
    }
}
