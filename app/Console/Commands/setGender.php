<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\Spouse;
class setGender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:gender';

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

        $affiliates=Affiliate::all();
        
        foreach ($affiliates as $key => $a) {

            if ($spouse = Spouse::where('affiliate_id',$a->id)->first()) {
                $spouse->civil_status='V';
                $spouse->save();
                $a->gender = 'M';
                $a->save();
            }
        }
    }
}
