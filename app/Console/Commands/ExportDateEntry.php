<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;


class ExportDateEntry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:date_entry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $affiliates;
        $aff=Affiliate::whereNull('date_entry')->get();
        foreach ($aff as $key => $afi) {
            $affiliates[]= array(
                'id' => $afi->id,
                'ci'=>$afi->identity_card,
                'p_nombre'=>$afi->first_name,
                's_nombre'=>$afi->second_name,
                'paterno'=>$afi->last_name,
                'materno'=>$afi->mothers_last_name,
                'apellido_casada'=>$afi->surname_husband,
                'fecha_nac'=>$afi->birth_date,
                'fecha_ing'=>$afi->date_entry,
            );
        }
        Excel::create('Reporte de afiliados sin fecha de ingreso '.date("Y-m-d H:i:s"),function($excel)
        {
            global $affiliates;
            $excel->sheet('afiliados',function($sheet){
                global $affiliates;
                $sheet->fromArray($affiliates);
            });
        })->store('xls', storage_path('excel/exports'));
    }
}
