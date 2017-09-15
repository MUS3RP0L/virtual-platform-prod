<?php

namespace Muserpol\Http\Controllers\Auth;

use Muserpol\User;
use Validator;
use Muserpol\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/ChangeRol';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function postLogin(Request $request)
    {

        if (Auth::attempt(
                [
                    'username' => $request->username,
                    'password' => $request->password,
                    'status' => 'active'
                ]
                )){
            // return redirect()->intended($this->redirectPath());
            return redirect("ChangeRol");
        }
        else{
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];

            $messages = [
                'username.required' => 'El Nombre de usuario es requerido',
                'password.required' => 'La Contraseña es requerida',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            return redirect('login')
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Nombre de usuario y contraseña no válidos');
        }
    }

}
