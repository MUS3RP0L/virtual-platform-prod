<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\AffiliateRecord;
use Log;
class UpdateAffiliateRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:UpdateAffiliateRecords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update columns category_id and pension_entity_id defaults values';

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
        // $this->ask('Total registros que serian afectados: '.$registros->count());
        //
        $total_registros = AffiliateRecord::count();
        $this->info('Total registros afectados '.$total_registros);
         $respuesta = $this->ask('desea actulizar los registros de  AffiliateRecords?');
          
//          Log::info("comensando importacion de ");
          //$registros = AffiliateRecord::find(1);
          if($respuesta=="9949018")
          {
                Log::info("registros ".$total_registros);

                $time_start = microtime(true);
                $this->info("Working.. .\n");
          
               
              for($i =1;$i<=$total_registros;$i++)
              {

                $registro = AffiliateRecord::find($i);
                $afiliado = Affiliate::where('id','=',$registro->affiliate_id)->first();
                if($afiliado->category_id)
                {
                    $registro->category_id = $afiliado->category_id; 
                }
                if($afiliado->pension_entity_id)
                {
                    $registro->pension_entity_id = $afiliado->pension_entity_id;    
                }
                              
                $registro->save();

                 $Progress = $this->output->createProgressBar();
                 $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                Log::info('Registrado .. id= '.$registro->id);
                // Log::info($afiliado);
                // Log::info('afiliado category_id='.$afiliado->category_id);
                // Log::info('afiliado pension_entity_id='.$afiliado->pension_entity_id);
              }

             //  foreach ($registros as $registro) {
             //   
             //       


             //    $afiliado = Affiliate::find($registro->Affiliate_id);
             //    $registro->category_id = $afiliado->category_id;
             //    $registro->pension_entity_id = $afiliado->pension_entity_id;
             //    $registro->save();

             //  } 

             $time_end = microtime(true);
             $execution_time = ($time_end - $time_start)/60;
             $Progress->finish();


            $this->info('termino lista :V tiempo'.$execution_time);
          }
          else{
            $this->info('no se pudo actulizar XD ');
          }
          
    }
}
