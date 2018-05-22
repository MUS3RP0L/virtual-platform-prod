<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;

use Maatwebsite\Excel\Facades\Excel;

class AffiliateWithIdReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:affiliate_with_id';

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
        global $row;
        $affiliates = Affiliate::whereIn('id', [6271, 15730, 10940, 6323, 15739, 10955, 15712, 10935, 10976, 6393, 6289, 19879, 10964, 6297, 6266, 6263, 6381, 14706, 11020, 2, 15727, 6309, 13298, 6326, 6308, 6290, 15725, 15787, 15721 ])->get();
        foreach ($affiliates as $affiliate) {
            $affiliate_state = $affiliate->affiliate_state;
            $applicant =  null;
            $afi = array(
                'ci_afiliado' => $affiliate->identity_card,
                'ci_expedicion_afiliado' => $affiliate->city_identity_card->first_shortened ?? null,
                'primer_nombre_afiliado' => $affiliate->first_name,
                'segundo_nombre_afiliado' => $affiliate->second_name,
                'paterno_afiliado' => $affiliate->last_name,
                'materno_afiliado' => $affiliate->mothers_last_name,
                'ape_casada_afiliado' => $affiliate->surname_husband,
                'genero_afiliado' => $affiliate->gender,
                'nua_cua' => $affiliate->nua_cua,
                'fecha_nac_afiliado' => $affiliate->birth_date,
                'lugar_nac_afiliado' => $affiliate->city_birth->name ?? null,
                'telefono' => $affiliate->phone_number,
                'celular' => $affiliate->cell_phone_number,
                'tipo' => $affiliate->type,
                'item' => $affiliate->item,
                'grado' => $affiliate->degree->name ?? null,
                'categoria' => $affiliate->category->name ?? null,
                'fecha_ingreso' => $affiliate->date_entry,
                'fecha_deceso' => $affiliate->date_death,
                'ente_gestor' => $affiliate->pension_entity->name ?? null,
                'estado' => $affiliate_state->name,
                'derechohabiente_ci' => null,
                'derechohabiente_exp' => null,
                'derechohabiente_primer_nombre' => null,
                'derechohabiente_segundo_nombre' => null,
                'derechohabiente_ap_pat' => null,
                'derechohabiente_ap_mat' => null,
                'derechohabiente_ap_casada' => null,
                'derechohabiente_fecha_nac' => null,
                'derechohabiente_genero' => null,
                'derechohabiente_telefono' => null,
                'derechohabiente_celular' => null,
            );
            if ($affiliate_state->id == 4) { #fallecido
                if ($eco = $affiliate->lastEconomicComplement()) {
                    $applicant = $eco->economic_complement_applicant;
                    $row_ap = array(
                        'derechohabiente_ci' => $applicant->identity_card,
                        'derechohabiente_exp' => $applicant->city_identity_card->first_shortened ?? null,
                        'derechohabiente_primer_nombre' => $applicant->first_name,
                        'derechohabiente_segundo_nombre' => $applicant->second_name,
                        'derechohabiente_ap_pat' => $applicant->last_name,
                        'derechohabiente_ap_mat' => $applicant->mothers_last_name,
                        'derechohabiente_ap_casada' => $applicant->surname_husband,
                        'derechohabiente_fecha_nac' => $applicant->birth_date,
                        'derechohabiente_genero' => $applicant->gender,
                        'derechohabiente_telefono' => $applicant->phone_number,
                        'derechohabiente_celular' => $applicant->cell_phone_number,
                    );
                    $row[]= array_merge($afi, $row_ap);
                }
            }else{
                $row[]= $afi;
            }
        }
        Excel::create('Lista Afiliados' . date("Y-m-d H:i:s"), function ($excel) use ($row) {
            global $row;
            $excel->sheet('afiliados', function ($sheet) use ($row) {
                global $row;
                $sheet->fromArray($row);
            });
        })->store('xls', storage_path('excel/exports'));
    }
}
