<?php

namespace Muserpol\Http\Controllers\EconomicComplement;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\ComplementaryFactor;
use Muserpol\Hierarchy;

class ComplementaryFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $year = Util::getYear(new Carbon());
        $semester = Util::getSemester(new Carbon());

        if (ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 1)->first()) {
            $complementary_factor = ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 1)->first();
            $cf1_old_age = $complementary_factor->old_age;
            $cf1_widowhood = $complementary_factor->widowhood;
        }else{
            $cf1_old_age = "";
            $cf1_widowhood = "";
        }

        if (ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 2)->first()) {
            $complementary_factor = ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 2)->first();
            $cf2_old_age = $complementary_factor->old_age;
            $cf2_widowhood = $complementary_factor->widowhood;
        }else{
            $cf2_old_age = "";
            $cf2_widowhood = "";
        }

        if (ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 3)->first()) {
            $complementary_factor = ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 3)->first();
            $cf3_old_age = $complementary_factor->old_age;
            $cf3_widowhood = $complementary_factor->widowhood;
        }else{
            $cf3_old_age = "";
            $cf3_widowhood = "";
        }

        if (ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 4)->first()) {
            $complementary_factor = ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 4)->first();
            $cf4_old_age = $complementary_factor->old_age;
            $cf4_widowhood = $complementary_factor->widowhood;
        }else{
            $cf4_old_age = "";
            $cf4_widowhood = "";
        }

        if (ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 5)->first()) {
            $complementary_factor = ComplementaryFactor::whereYear('year', '=', $year)->where('semester', '=', $semester)->where('hierarchy_id', '=', 5)->first();
            $cf5_old_age = $complementary_factor->old_age;
            $cf5_widowhood = $complementary_factor->widowhood;
        }else{
            $cf5_old_age = "";
            $cf5_widowhood = "";
        }

        $data = [

            'year' => $year,
            'semester' => $semester,
            'cf1_old_age' => $cf1_old_age,
            'cf1_widowhood' => $cf1_widowhood,
            'cf2_old_age' => $cf2_old_age,
            'cf2_widowhood' => $cf2_widowhood,
            'cf3_old_age' => $cf3_old_age,
            'cf3_widowhood' => $cf3_widowhood,
            'cf4_old_age' => $cf4_old_age,
            'cf4_widowhood' => $cf4_widowhood,
            'cf5_old_age' => $cf5_old_age,
            'cf5_widowhood' => $cf5_widowhood,
        ];

        return view('complementary_factor.index', $data);

    }

    public function old_ageData()
    {
        $select = DB::raw('complementary_factors.year as year, complementary_factors.semester as semester, cf1.old_age as cf1, cf2.old_age as cf2, cf3.old_age as cf3, cf4.old_age as cf4, cf5.old_age as cf5');

        $complementary_factors = DB::table('complementary_factors')->select($select)
        ->leftJoin('complementary_factors as cf1', 'cf1.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf2', 'cf2.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf3', 'cf3.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf4', 'cf4.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf5', 'cf5.year', '=', 'complementary_factors.year')

        ->where('cf1.hierarchy_id', '=', '1')
        ->where('cf2.hierarchy_id', '=', '2')
        ->where('cf3.hierarchy_id', '=', '3')
        ->where('cf4.hierarchy_id', '=', '4')
        ->where('cf5.hierarchy_id', '=', '5')

        ->groupBy('complementary_factors.year', 'complementary_factors.semester');

        return Datatables::of($complementary_factors)
        ->editColumn('year', function ($complementary_factor) { return Carbon::parse($complementary_factor->year)->year; })
        ->editColumn('semester', function ($complementary_factor) { return $complementary_factor->semester; })
        ->editColumn('cf1', function ($complementary_factor) { return $complementary_factor->cf1; })
        ->editColumn('cf2', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf2); })
        ->editColumn('cf3', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf3); })
        ->editColumn('cf4', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf4); })
        ->editColumn('cf5', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf5); })

        ->make(true);
    }


    public function widowhoodData()
    {
        $select = DB::raw('complementary_factors.year as year, complementary_factors.semester as semester, cf1.widowhood as cf1, cf2.widowhood as cf2, cf3.widowhood as cf3, cf4.widowhood as cf4, cf5.widowhood as cf5');

        $complementary_factors = DB::table('complementary_factors')->select($select)
        ->leftJoin('complementary_factors as cf1', 'cf1.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf2', 'cf2.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf3', 'cf3.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf4', 'cf4.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf5', 'cf5.year', '=', 'complementary_factors.year')

        ->where('cf1.hierarchy_id', '=', '1')
        ->where('cf2.hierarchy_id', '=', '2')
        ->where('cf3.hierarchy_id', '=', '3')
        ->where('cf4.hierarchy_id', '=', '4')
        ->where('cf5.hierarchy_id', '=', '5')

        ->groupBy('complementary_factors.year', 'complementary_factors.semester');

        return Datatables::of($complementary_factors)
        ->editColumn('year', function ($complementary_factor) { return Carbon::parse($complementary_factor->year)->year; })
        ->editColumn('semester', function ($complementary_factor) { return $complementary_factor->semester; })
        ->editColumn('cf1', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf1); })
        ->editColumn('cf2', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf2); })
        ->editColumn('cf3', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf3); })
        ->editColumn('cf4', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf4); })
        ->editColumn('cf5', function ($complementary_factor) { return Util::formatPercentage($complementary_factor->cf5); })

        ->make(true);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $complementary_factor)
    {
        if (Auth::user()->can('manage')) {

            return $this->save($request, $complementary_factor);

        }else{

            return redirect('/');
        }
    }

    public function save($request, $complementary_factor = false)
    {
        $rules = [

            'year' => 'required',
            'semester' => 'required',
            'cf1_old_age' => 'required|numeric|between:1,100',
            'cf1_widowhood' => 'required|numeric|between:1,100',
            'cf2_old_age' => 'required|numeric|between:1,100',
            'cf2_widowhood' => 'required|numeric|between:1,100',
            'cf3_old_age' => 'required|numeric|between:1,100',
            'cf3_widowhood' => 'required|numeric|between:1,100',
            'cf4_old_age' => 'required|numeric|between:1,100',
            'cf4_widowhood' => 'required|numeric|between:1,100',
            'cf5_old_age' => 'required|numeric|between:1,100',
            'cf5_widowhood' => 'required|numeric|between:1,100'

        ];

        $messages = [

            'cf1_old_age.required' => 'El campo Generales no puede ser vacío',
            'cf1_old_age.numeric' => 'El campo Generales sólo se aceptan números',
            'cf1_old_age.between' => 'El campo Generales sólo acepta números entre 1 y 100 %',

            'cf1_widowhood.required' => 'El campo Generales no puede ser vacío',
            'cf1_widowhood.numeric' => 'El campo Generales sólo se aceptan números',
            'cf1_widowhood.between' => 'El campo Generales sólo acepta números entre 1 y 100 %',

            'cf2_old_age.required' => 'El campo Jefes y Oficiales no puede ser vacío',
            'cf2_old_age.numeric' => 'El campo Jefes y Oficiales sólo se aceptan números',
            'cf2_old_age.between' => 'El campo Jefes y Oficiales sólo acepta números entre 1 y 100 %',

            'cf2_widowhood.required' => 'El campo Jefes y Oficiales no puede ser vacío',
            'cf2_widowhood.numeric' => 'El campo Jefes y Oficiales sólo se aceptan números',
            'cf2_widowhood.between' => 'El campo Jefes y Oficiales sólo acepta números entre 1 y 100 %',

            'cf3_old_age.required' => 'El campo Jefes y Oficiales Amdtvos no puede ser vacío',
            'cf3_old_age.numeric' => 'El campo Jefes y Oficiales Amdtvos sólo se aceptan números',
            'cf3_old_age.between' => 'El campo Jefes y Oficiales Amdtvos sólo acepta números entre 1 y 100 %',

            'cf3_widowhood.required' => 'El campo Jefes y Oficiales Amdtvos no puede ser vacío',
            'cf3_widowhood.numeric' => 'El campo Jefes y Oficiales Amdtvos sólo se aceptan números',
            'cf3_widowhood.between' => 'El campo Jefes y Oficiales Amdtvos sólo acepta números entre 1 y 100 %',

            'cf4_old_age.required' => 'El campo Suboficiales, Clases y Policias no puede ser vacío',
            'cf4_old_age.numeric' => 'El campo Suboficiales, Clases y Policias sólo se aceptan números',
            'cf4_old_age.between' => 'El campo Suboficiales, Clases y Policias sólo acepta números entre 1 y 100 %',

            'cf4_widowhood.required' => 'El campo Suboficiales, Clases y Policias no puede ser vacío',
            'cf4_widowhood.numeric' => 'El campo Suboficiales, Clases y Policias sólo se aceptan números',
            'cf4_widowhood.between' => 'El campo Suboficiales, Clases y Policias sólo acepta números entre 1 y 100 %',

            'cf5_old_age.required' => 'El campo Suboficiales, Clases y Policias Admtvos no puede ser vacío',
            'cf5_old_age.numeric' => 'El campo Suboficiales, Clases y Policias Admtvos sólo se aceptan números',
            'cf5_old_age.between' => 'El campo Suboficiales, Clases y Policias Admtvos sólo acepta números entre 1 y 100 %',

            'cf5_widowhood.required' => 'El campo Suboficiales, Clases y Policias Admtvos no puede ser vacío',
            'cf5_widowhood.numeric' => 'El campo Suboficiales, Clases y Policias Admtvos sólo se aceptan números',
            'cf5_widowhood.between' => 'El campo Suboficiales, Clases y Policias Admtvos sólo acepta números entre 1 y 100 %'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('complementary_factor')
            ->withErrors($validator)
            ->withInput();
        }
        else{

            $complementary_factor_cf1 = ComplementaryFactor::whereYear('year', '=', Util::getYear($request->year))
                                    ->where('semester', '=', $request->semester)->where('hierarchy_id', '=', 1)->first();
            if (!$complementary_factor_cf1) {
                $complementary_factor_cf1 = new ComplementaryFactor();
                $complementary_factor_cf1->user_id = Auth::user()->id;
                $complementary_factor_cf1->hierarchy_id = 1;
                $complementary_factor_cf1->year = Util::datePickYear($request->year, trim($request->semester));
                $complementary_factor_cf1->semester = trim($request->semester);
            }
            $complementary_factor_cf1->old_age = trim($request->cf1_old_age);
            $complementary_factor_cf1->widowhood = trim($request->cf1_widowhood);
            $complementary_factor_cf1->save();

            $complementary_factor_cf2 = ComplementaryFactor::whereYear('year', '=', Util::getYear($request->year))
                                    ->where('semester', '=', $request->semester)->where('hierarchy_id', '=', 2)->first();
            if (!$complementary_factor_cf2) {
                $complementary_factor_cf2 = new ComplementaryFactor();
                $complementary_factor_cf2->user_id = Auth::user()->id;
                $complementary_factor_cf2->hierarchy_id = 2;
                $complementary_factor_cf2->year = Util::datePickYear($request->year, trim($request->semester));
                $complementary_factor_cf2->semester = trim($request->semester);
            }
            $complementary_factor_cf2->old_age = trim($request->cf2_old_age);
            $complementary_factor_cf2->widowhood = trim($request->cf2_widowhood);
            $complementary_factor_cf2->save();

            $complementary_factor_cf3 = ComplementaryFactor::whereYear('year', '=', Util::getYear($request->year))
                                    ->where('semester', '=', $request->semester)->where('hierarchy_id', '=', 3)->first();
            if (!$complementary_factor_cf3) {
                $complementary_factor_cf3 = new ComplementaryFactor();
                $complementary_factor_cf3->user_id = Auth::user()->id;
                $complementary_factor_cf3->hierarchy_id = 3;
                $complementary_factor_cf3->year = Util::datePickYear($request->year, trim($request->semester));
                $complementary_factor_cf3->semester = trim($request->semester);
            }
            $complementary_factor_cf3->old_age = trim($request->cf3_old_age);
            $complementary_factor_cf3->widowhood = trim($request->cf3_widowhood);
            $complementary_factor_cf3->save();

            $complementary_factor_cf4 = ComplementaryFactor::whereYear('year', '=', Util::getYear($request->year))
                                    ->where('semester', '=', $request->semester)->where('hierarchy_id', '=', 4)->first();
            if (!$complementary_factor_cf4) {
                $complementary_factor_cf4 = new ComplementaryFactor();
                $complementary_factor_cf4->user_id = Auth::user()->id;
                $complementary_factor_cf4->hierarchy_id = 4;
                $complementary_factor_cf4->year = Util::datePickYear($request->year, trim($request->semester));
                $complementary_factor_cf4->semester = trim($request->semester);
            }
            $complementary_factor_cf4->old_age = trim($request->cf4_old_age);
            $complementary_factor_cf4->widowhood = trim($request->cf4_widowhood);
            $complementary_factor_cf4->save();

            $complementary_factor_cf5 = ComplementaryFactor::whereYear('year', '=', Util::getYear($request->year))
                                    ->where('semester', '=', $request->semester)->where('hierarchy_id', '=', 5)->first();
            if (!$complementary_factor_cf5) {
                $complementary_factor_cf5 = new ComplementaryFactor();
                $complementary_factor_cf5->user_id = Auth::user()->id;
                $complementary_factor_cf5->hierarchy_id = 5;
                $complementary_factor_cf5->year = Util::datePickYear($request->year, trim($request->semester));
                $complementary_factor_cf5->semester = trim($request->semester);
            }
            $complementary_factor_cf5->old_age = trim($request->cf5_old_age);
            $complementary_factor_cf5->widowhood = trim($request->cf5_widowhood);
            $complementary_factor_cf5->save();

            $message = "Factores de Complementación actualizados con éxito";
            Session::flash('message', $message);
        }

        return redirect('complementary_factor');
    }
}
