<?php

namespace Muserpol\Http\Controllers\Wage;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;

use Muserpol\BaseWage;

class BaseWageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        return view('base_wages.index');
    }

    public function FirstLevelData()
    {
        $select = DB::raw('base_wages.month_year as month_year, c1.amount as c1, c2.amount as c2, c3.amount as c3, c4.amount as c4, c5.amount as c5, c6.amount as c6, c7.amount as c7, c8.amount as c8, c9.amount as c9, c10.amount as c10, c11.amount as c11, c12.amount as c12');
        
        $base_wages = DB::table('base_wages')->select($select)
        ->leftJoin('base_wages as c1', 'c1.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c2', 'c2.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c3', 'c3.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c4', 'c4.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c5', 'c5.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c6', 'c6.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c7', 'c7.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c8', 'c8.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c9', 'c9.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c10', 'c10.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c11', 'c11.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c12', 'c12.month_year', '=', 'base_wages.month_year')
        ->where('c1.degree_id', '=', '1')
        ->where('c2.degree_id', '=', '2')
        ->where('c3.degree_id', '=', '3')
        ->where('c4.degree_id', '=', '4')
        ->where('c5.degree_id', '=', '5')
        ->where('c6.degree_id', '=', '6')
        ->where('c7.degree_id', '=', '7')
        ->where('c8.degree_id', '=', '8')
        ->where('c9.degree_id', '=', '9')
        ->where('c10.degree_id', '=', '10')
        ->where('c11.degree_id', '=', '11')
        ->where('c12.degree_id', '=', '12')
        ->groupBy('base_wages.month_year');

        return Datatables::of($base_wages)
        ->editColumn('year', function ($base_wage) { return Carbon::parse($base_wage->month_year)->year; })
        ->editColumn('c1', function ($base_wage) { return Util::formatMoney($base_wage->c1); })
        ->editColumn('c2', function ($base_wage) { return Util::formatMoney($base_wage->c2); })
        ->editColumn('c3', function ($base_wage) { return Util::formatMoney($base_wage->c3); })
        ->editColumn('c4', function ($base_wage) { return Util::formatMoney($base_wage->c4); })
        ->editColumn('c5', function ($base_wage) { return Util::formatMoney($base_wage->c5); })
        ->editColumn('c6', function ($base_wage) { return Util::formatMoney($base_wage->c6); })
        ->editColumn('c7', function ($base_wage) { return Util::formatMoney($base_wage->c7); })
        ->editColumn('c8', function ($base_wage) { return Util::formatMoney($base_wage->c8); })
        ->editColumn('c9', function ($base_wage) { return Util::formatMoney($base_wage->c9); })
        ->editColumn('c10', function ($base_wage) { return Util::formatMoney($base_wage->c10); })
        ->editColumn('c11', function ($base_wage) { return Util::formatMoney($base_wage->c11); })
        ->editColumn('c12', function ($base_wage) { return Util::formatMoney($base_wage->c12); })
        ->make(true);
    }

    public function SecondLevelData()
    {
        $select = DB::raw('base_wages.month_year as month_year, c13.amount as c13, c14.amount as c14, c15.amount as c15, c16.amount as c16, c17.amount as c17,c18.amount as c18');
        
        $base_wages = DB::table('base_wages')->select($select)
        ->leftJoin('base_wages as c13', 'c13.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c14', 'c14.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c15', 'c15.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c16', 'c16.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c17', 'c17.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c18', 'c18.month_year', '=', 'base_wages.month_year')
        ->where('c13.degree_id', '=', '13')
        ->where('c14.degree_id', '=', '14')
        ->where('c15.degree_id', '=', '15')
        ->where('c16.degree_id', '=', '16')
        ->where('c17.degree_id', '=', '17')
        ->where('c18.degree_id', '=', '18')
        ->groupBy('base_wages.month_year');

        return Datatables::of($base_wages)
        ->editColumn('year', function ($base_wage) { return Carbon::parse($base_wage->month_year)->year; })
        ->editColumn('c13', function ($base_wage) { return Util::formatMoney($base_wage->c13); })
        ->editColumn('c14', function ($base_wage) { return Util::formatMoney($base_wage->c14); })
        ->editColumn('c15', function ($base_wage) { return Util::formatMoney($base_wage->c15); })
        ->editColumn('c16', function ($base_wage) { return Util::formatMoney($base_wage->c16); })
        ->editColumn('c17', function ($base_wage) { return Util::formatMoney($base_wage->c17); })
        ->editColumn('c18', function ($base_wage) { return Util::formatMoney($base_wage->c18); })
        ->make(true);
    }

    public function ThirdLevelData()
    {
        $select = DB::raw('base_wages.month_year as month_year, c19.amount as c19, c20.amount as c20, c21.amount as c21, c22.amount as c22, c23.amount as c23, c24.amount as c24, c25.amount as c25, c26.amount as c26');
        
        $base_wages = DB::table('base_wages')->select($select)
        ->leftJoin('base_wages as c19', 'c19.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c20', 'c20.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c21', 'c21.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c22', 'c22.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c23', 'c23.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c24', 'c24.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c25', 'c25.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c26', 'c26.month_year', '=', 'base_wages.month_year')
        ->where('c19.degree_id', '=', '19')
        ->where('c20.degree_id', '=', '20')
        ->where('c21.degree_id', '=', '21')
        ->where('c22.degree_id', '=', '22')
        ->where('c23.degree_id', '=', '23')
        ->where('c24.degree_id', '=', '24')
        ->where('c25.degree_id', '=', '25')
        ->where('c26.degree_id', '=', '26')
        ->groupBy('base_wages.month_year');

        return Datatables::of($base_wages)
        ->editColumn('year', function ($base_wage) { return Carbon::parse($base_wage->month_year)->year; })
        ->editColumn('c19', function ($base_wage) { return Util::formatMoney($base_wage->c19); })
        ->editColumn('c20', function ($base_wage) { return Util::formatMoney($base_wage->c20); })
        ->editColumn('c21', function ($base_wage) { return Util::formatMoney($base_wage->c21); })
        ->editColumn('c22', function ($base_wage) { return Util::formatMoney($base_wage->c22); })
        ->editColumn('c23', function ($base_wage) { return Util::formatMoney($base_wage->c23); })
        ->editColumn('c24', function ($base_wage) { return Util::formatMoney($base_wage->c24); })
        ->editColumn('c25', function ($base_wage) { return Util::formatMoney($base_wage->c25); })
        ->editColumn('c26', function ($base_wage) { return Util::formatMoney($base_wage->c26); })
        ->make(true);
    }

    public function FourthLevelData()
    {
        $select = DB::raw('base_wages.month_year as month_year, c27.amount as c27, c28.amount as c28, c29.amount as c29, c30.amount as c30, c31.amount as c31, c32.amount as c32, c33.amount as c33, c34.amount as c34');
        
        $base_wages = DB::table('base_wages')->select($select)
        ->leftJoin('base_wages as c27', 'c27.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c28', 'c28.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c29', 'c29.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c30', 'c30.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c31', 'c31.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c32', 'c32.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c33', 'c33.month_year', '=', 'base_wages.month_year')
        ->leftJoin('base_wages as c34', 'c34.month_year', '=', 'base_wages.month_year')
        ->where('c27.degree_id', '=', '27')
        ->where('c28.degree_id', '=', '28')
        ->where('c29.degree_id', '=', '29')
        ->where('c30.degree_id', '=', '30')
        ->where('c31.degree_id', '=', '31')
        ->where('c32.degree_id', '=', '32')
        ->where('c33.degree_id', '=', '33')
        ->where('c34.degree_id', '=', '34')
        ->groupBy('base_wages.month_year');

        return Datatables::of($base_wages)
        ->editColumn('year', function ($base_wage) { return Carbon::parse($base_wage->month_year)->year; })
        ->editColumn('c27', function ($base_wage) { return Util::formatMoney($base_wage->c27); })
        ->editColumn('c28', function ($base_wage) { return Util::formatMoney($base_wage->c28); })
        ->editColumn('c29', function ($base_wage) { return Util::formatMoney($base_wage->c29); })
        ->editColumn('c30', function ($base_wage) { return Util::formatMoney($base_wage->c30); })
        ->editColumn('c31', function ($base_wage) { return Util::formatMoney($base_wage->c31); })
        ->editColumn('c32', function ($base_wage) { return Util::formatMoney($base_wage->c32); })
        ->editColumn('c33', function ($base_wage) { return Util::formatMoney($base_wage->c33); })
        ->editColumn('c34', function ($base_wage) { return Util::formatMoney($base_wage->c34); })
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

    public function save($request, $base_wage = false)
    {
        global $month_year, $results;

        $reader = $request->file('archive');
        $filename = $reader->getRealPath();
        $month_year = $request->month_year;

        Excel::load($filename, function($reader) {
            
            global $month_year, $results;
    
            ini_set('upload_max_filesize', '9999M');
            ini_set('post_max_size', '9999M');
            ini_set('max_execution_time', '-1');
            ini_set('max_input_time', '-1');
            ini_set('memory_limit', '-1');
            set_time_limit(36000);

            $results = collect($reader->select(array('niv', 'gra','sue'))->get());
            
        });

        $degrees = DB::table('degrees')-> orderBy('id','asc')->get();
      
        foreach ($degrees as $item) {
           
            foreach ($results as $datos) {

                if($datos['niv'] == $item->niv && $datos['gra'] == $item->grad && Util::decimal($datos['sue'])<> 0)
                {     
                    $date = Util::datePickPeriod($month_year);
                    $year = Carbon::parse($date)->year;
                    $month = Carbon::parse($date)->month;

                    $base_wage =  DB::table('base_wages')
                            ->select(DB::raw('base_wages.degree_id, degrees.code_level, degrees.code_degree, base_wages.month_year'))
                            ->leftJoin('degrees', 'base_wages.degree_id', '=', 'degrees.id')
                            ->where('code_level', '=', $item->niv)
                            ->where('code_degree', '=', $item->grad)
                            ->whereMonth('month_year', '=', $month)
                            ->whereYear('month_year', '=', $year)
                            ->first(); 
                    
                    if(!$base_wage)
                    { 
                        $base_wage = new BaseWage;
                        $base_wage->user_id = Auth::user()->id;
                        $base_wage->degree_id = $item->id;
                        $base_wage->month_year = Util::datePickPeriod($month_year);
                        $base_wage->amount = Util::decimal($datos['sue']); 
                        $base_wage->save();                   
                    }
                    break; 
                } 
              
            }
           
        }

        Session::flash('message', "Sueldos importados exitosamente");
        return redirect('base_wage');
  
    }
}

