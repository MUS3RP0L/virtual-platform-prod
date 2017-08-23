<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;

use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;


use Log;
use Illuminate\Support\Facades\DB;

class ObservationDegreeAndCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:ObservationDegreeAndCategory';

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
        //
        $this->info("Realizando observaciones");

        $ids_grado = [10426,10825,10468,7730,8476,9149,5307,7500,8388,6509,7446,8589,8952,7049,9147,9143,9706,8155,6102,8156,9012,9714,9953,9916,8424,8549,9220,8232,8338,6343,9724,9591,9387,6248,8520,6489,9186,7179,9358,9921,9042,9125,10883,8038,9699,5945,7765,7614,8143,7971,9313,9674,8095,7055,9113,5530,8376,8651,9709,8043,9665,7220,6850,5692,5653,8099,8766,7756,6316,9684,8505,9280,7413,8448,7916,8138,6607,7299,8416,6703,9456,9201,8144,5967,8855,8286,10769,9048,6389,9544,10276,8624,8551,6702,10778];
        $ids_categoria = [10897,10893,10289,10895,10894,10312,10376,10389,10394,10410,10412,10415,10825,10448,10460,10462,10468,10484,10496,10498,7737,6575,10792,7029,8336,7770,8369,5890,6973,9922,7497,7031,7345,7560,6113,6482,9472,6321,7500,6509,8039,7446,9521,9945,9538,8815,10775,6936,8589,5934,8525,9600,9914,5469,7666,8545,9706,8155,9290,9342,8866,7954,6578,9012,10710,8446,9916,7265,6378,9497,5472,5725,6134,7909,7280,9413,6742,8464,5637,9826,9944,5952,8105,9670,6558,9508,9400,7372,6257,7152,9685,8120,9796,6400,8124,9125,7911,8038,6429,8600,6786,6301,7587,7310,6306,9391,7607,8192,5640,8956,8271,8101,7099,6431,5376,9758,8143,5557,9597,7802,8049,8026,5702,8229,9930,10846,6075,6690,7211,6571,8438,9709,8577,9569,7032,9789,5662,7274,6850,8459,8599,8237,8121,6831,7602,5487,6281,6422,8116,6316,8869,5526,7147,9052,9254,6568,9065,9301,9397,8448,6911,6185,8695,7214,7456,6709,6160,6879,7498,8941,8416,5854,6010,7435,6958,9456,7800,8144,8855,8786,10751,8931,8977,8318,5298,7481,9742,9558,8277,7090,6435,9048,6602,8499,8537,6171,9616,5579,5473,8053,10520,10530,10534,10545,10548,10567,8001,10636,10640,10649,10660,10327,10330,9995,10049,10055,6498,6963,7465,6384,9548,8585,5658,9740,8518,7789,9700,9330,7043,10745,9804,6515,8109,9848,6723,7776,6553,7690,7893,8274,9444,6103,7377,10851,10139,10788,10158,10166,10789,10174,10841,10215,10233,10257];
        

        $complementos_grados = EconomicComplement::whereIn('id',$ids_grado)->get();

        foreach ($complementos_grados as $complemento) {
            # code...
          
           $observacion = new AffiliateObservation;
           $observacion->user_id = 1;
           $observacion->date = date('Y-m-d');
           $observacion->message = "Observado por cambio indebido de grado";
           $observacion->affiliate_id = $complemento->affiliate_id;
           $observacion->observation_type_id = 15;
           $observacion->is_enabled =false;
           $observacion->save();
           $this->info("grado = ". $observacion->id);
        }

        $complementos_categorias = EconomicComplement::whereIn('id',$ids_categoria)->get();

        foreach ($complementos_categorias as $complemento) {
            # code...
        
           $observacion = new AffiliateObservation;
           $observacion->user_id = 1;
           $observacion->date = date('Y-m-d');
           $observacion->message = "Observado por cambio indebido de Categoria";
           $observacion->affiliate_id = $complemento->affiliate_id;
           $observacion->observation_type_id = 14;
           $observacion->is_enabled =false;
           $observacion->save();

           $this->info("categoria = ". $observacion->id);
        }

        $this->info("ids grado ".sizeof($ids_grado));
        $this->info("ids categoria ".sizeof($ids_categoria));

        $this->info("complementos_grados ".sizeof($complementos_grados));
        $this->info("complementos_categorias ".sizeof($complementos_categorias));

        $this->info("observaciones terminadas ");

    }
}
