<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use Carbon\Carbon;
use Muserpol\ContributionRate;

class CreateContributionRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'create:contributionrate';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Creating monthly contribution rate';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {   
        $last_contributionrate = ContributionRate::orderBy('month_year', 'desc')->first();
        
        if (Carbon::parse($last_contributionrate->month_year)->addMonth() < $date = new Carbon()) {
            
            $new_contributionrate = new ContributionRate;
            $new_contributionrate->user_id = 1;
            $new_contributionrate->retirement_fund = $last_contributionrate->retirement_fund;
            $new_contributionrate->mortuary_quota = $last_contributionrate->mortuary_quota;
            $new_contributionrate->rate_active = $new_contributionrate->rate_active;
            $new_contributionrate->mortuary_aid = $last_contributionrate->mortuary_aid;
            
            $fecha = Carbon::parse($last_contributionrate->month_year);
            $new_contributionrate->month_year = Carbon::parse($last_contributionrate->month_year)->addMonth();
            $new_contributionrate->save();

            $year = Carbon::parse($new_contributionrate->month_year)->year;
            $month = Carbon::parse($new_contributionrate->month_year)->month;
            \Storage::disk('local')->put('ContributionRate_'. $month . '-' . $year . '.txt', "Contribution rate successfully updated: " . $new_contributionrate->index);

        }
    }
}
