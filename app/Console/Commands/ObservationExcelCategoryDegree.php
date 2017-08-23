<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;

use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Log;
use Illuminate\Support\Facades\DB;

class ObservationExcelCategoryDegree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:ObservationExcelCategoryDegree';

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
        $this->info("Importacion del puto excel");
        $ci_grado = ["1267951","1681341","852766","2214164","2042821","399779","468460","2090295","2325685","602091","244058"];
        $ci_categoria = ["1721105","1722416","1026382","855328","386749","395035","238293","106355","3328862","331291","461904","256840","2055731","192908","495062","496603","379635","1264748","467890","104010","218107","122288","4847058","338235","2521656","148825-1E","375996","320699","524004","617060","2721505-1H","1553991","436821","1813554","835744","1616343"];
         $i=0;
         $j=0;
        foreach ($ci_grado as $ci) {
            # code...
            $complemento = EconomicComplementApplicant::where('identity_card',$ci)->first()->economic_complement->affiliate->economic_complements()->where('eco_com_procedure_id','=',2)->first();
           
            if ($complemento) {
                $i++;
                   $observacion = new AffiliateObservation;
                   $observacion->user_id = 1;
                   $observacion->date = date('Y-m-d');
                   $observacion->message = "Observado por cambio indebido de grado";
                   $observacion->affiliate_id = $complemento->affiliate_id;
                   $observacion->observation_type_id = 15;
                   $observacion->is_enabled =false;

                   $this->info("id_grado=".$complemento->id);
                   $observacion->save();
            }
        }

        foreach ($ci_categoria as $ci) {
            # code...
            $complemento = EconomicComplementApplicant::where('identity_card',$ci)->first()->economic_complement->affiliate->economic_complements()->where('eco_com_procedure_id','=',2)->first();
            if ($complemento) {
                    $j++;
                   $observacion = new AffiliateObservation;
                   $observacion->user_id = 1;
                   $observacion->date = date('Y-m-d');
                   $observacion->message = "Observado por cambio indebido de categoria";
                   $observacion->affiliate_id = $complemento->affiliate_id;
                   $observacion->observation_type_id = 14;
                   $observacion->is_enabled =false;

                   $this->info("id_categoria=".$complemento->id);
                   $observacion->save();

            }
        }
        $this->info("------------------------------------------ XD ---------------------------------------");
        $this->info("ids_grado= ".sizeof($ci_grado));
        $this->info("ids_categoria= ".sizeof($ci_categoria));
        $this->info("grado= ".$i);
        $this->info("categoria= ".$j);


    }
}
