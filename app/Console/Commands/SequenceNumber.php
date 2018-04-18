<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\WorkflowState;

class SequenceNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:SequenceNumber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generacion Secuencia Numerica para Estados';

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
        $this->info("Generando Secuencias");

        $wf_states = WorkflowState::orderBy('id')->get();
        foreach($wf_states as $state){
            switch($state->role_id)
            {
                case 22:
                case 23:
                case 24:
                case 25:
                case 26:
                case 27:
                    $state->sequence_number = 0;
                    break;
                case 2:
                    $state->sequence_number = 1;
                    break;
                case 4:
                    $state->sequence_number = 2;
                    break;
                case 5:
                    $state->sequence_number = 3;
                    break;
                case 6:
                    $state->sequence_number = 4;
                    break;
                case 19:
                    $state->sequence_number = 5;
                    break;
                case 20:
                    $state->sequence_number = 6;
                    break;
                case 21:
                    $state->sequence_number = 7;
                    break;
                case 7:
                    $state->sequence_number = 8;
                    break;
                case 8:
                    $state->sequence_number = 9;
                    break;
                case 9:
                    $state->sequence_number = 10;
                    break;
                case 15:
                    $state->sequence_number = 11;
                    break;

            }
            $state->save();
            
        }
        $wf_states = WorkflowState::orderBy('sequence_number')->get();
        foreach($wf_states as $state){
            $this->info($state->sequence_number.' '.$state->name);
        }
        $this->info('----------------------------');
        $this->info('Auspiciado por Brian y Tatis');
    }
}
