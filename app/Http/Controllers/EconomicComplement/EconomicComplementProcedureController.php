<?php

namespace Muserpol\Http\Controllers\EconomicComplement;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\EconomicComplementProcedure;

class EconomicComplementProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('economic_complements.procedure.index');
    }
    public function Data(Request $request)
    {
        $procedures = EconomicComplementProcedure::select(['id', 'year', 'semester', 'normal_start_date', 'normal_end_date', 'lagging_start_date', 'lagging_end_date',  'additional_start_date', 'additional_end_date']);
        return Datatables::of($procedures)
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $year=Carbon::now()->year;
        return view('economic_complements.procedure.create',['year'=>$year]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save($request, $eco_com_pro=false)
    {
        if ($eco_com_pro) {
            $rules = [
                'year' => 'required',
                'semester' => 'required',
                'normal_start_date' => 'required|min:3',
                'normal_end_date' => 'required|min:3',
                'lagging_start_date' => 'required|min:3',
                'lagging_end_date' => 'required|min:3',
                'additional_start_date' => 'required|min:3',
                'additional_end_date' => 'required|min:3'
            ];
        }
        else {

            $rules = [

                'year' => 'required',
                'semester' => 'required',
                'normal_start_date' => 'required|min:3',
                'normal_end_date' => 'required|min:3',
                'lagging_start_date' => 'required|min:3',
                'lagging_end_date' => 'required|min:3',
                'additional_start_date' => 'required|min:3',
                'additional_end_date' => 'required|min:3'

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
            return redirect($eco_com_pro ? 'economic_complement_procedure/'.$eco_com_pro->id.'/edit' : 'economic_complement_procedure/create')
            ->withErrors($validator)
            ->withInput();
        }
        else{
            $eco_com_pro=EconomicComplementProcedure::where('year','=',Carbon::create(Carbon::now()->year, 1, 1, 0, 0, 0))->where('semester','=','Segundo')->first();
            if ($eco_com_pro) {
                $message = "Rango de fechas Actualizado";
            }else {
                $eco_com_pro = new EconomicComplementProcedure();
                $message = "Rango de Fechas Creado con éxito";
            }
            $eco_com_pro->year=Carbon::create(Carbon::now()->year, 1, 1, 0, 0, 0);
            $eco_com_pro->user_id=Auth::user()->id;
            $eco_com_pro->semester=$request->semester;
            $eco_com_pro->normal_start_date=$request->normal_start_date;
            $eco_com_pro->normal_end_date=$request->normal_end_date;
            $eco_com_pro->lagging_start_date=$request->lagging_start_date;
            $eco_com_pro->lagging_end_date=$request->lagging_end_date;
            $eco_com_pro->additional_start_date=$request->additional_start_date;
            $eco_com_pro->additional_end_date=$request->additional_end_date;
            $eco_com_pro->save();
            
            Session::flash('message', $message);
        }
        return redirect('economic_complement_procedure');
    }
    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
