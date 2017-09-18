<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Log;
class FusionOnlyAffiliate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fusion:only_affiliate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fusion de un solo afiliado';

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
        
        // $new_affi_with_ext=Affiliate::where('identity_card','like','%-%')->get();
        // $affiliates_all=Affiliate::all();
        $count=0;
        $affi_count=0;
        $count_activities=0;
        $count_observations=0;
        $count_contributions=0;
        $count_records=0;
        $count_ecom=0;
        $count_spouse=0;
        // foreach ($affiliates_all as $old_affiliate) {
        //     foreach ($new_affi_with_ext as $new_affiliate) {
                // if ($old_affiliate->identity_card == explode('-', $new_affiliate->identity_card)[0]) {
                $old_affiliate=Affiliate::find(15582);
                $new_affiliate=Affiliate::find(54000);
                    $affi_count++;
                    $activities = \Muserpol\Activity::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($activities->count()) {
                        foreach ($activities as $activitie) {
                            $activitie->affiliate_id = $new_affiliate->id;
                            $activitie->save();
                            $count_activities++;
                        }
                        Log::info("activities");
                    }
                    $affiliate_observations = \Muserpol\AffiliateObservation::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($affiliate_observations->count()) {
                        foreach ($affiliate_observations as $affobs) {
                            $affobs->affiliate_id = $new_affiliate->id;
                            $affobs->save();
                            $count_observations++;
                        }
                        Log::info("Affiliate Observations");
                    }
                    $contributions = \Muserpol\Contribution::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($contributions->count()) {
                        foreach ($contributions as $cont) {
                            $cont->affiliate_id = $new_affiliate->id;
                            $cont->save();
                            $count_contributions++;
                        }
                        Log::info("contributions");
                    }
                    $affiliate_records = \Muserpol\AffiliateRecord::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($affiliate_records->count()) {
                        foreach ($affiliate_records as $affirecord) {
                            $affirecord->affiliate_id=$new_affiliate->id;
                            $affirecord->save();
                            $count_records++;
                        }
                        Log::info("affiliate records");
                    }
                    //no hay registros en direct contributions
                    // $direct_contributions = \Muserpol\DirectContribution::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($direct_contributions->count()) {
                    //     Log::info("direct COntr");
                    // }

                    $economic_complements = \Muserpol\EconomicComplement::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($economic_complements->count()) {
                        foreach ($economic_complements as $economic) {
                            $economic->affiliate_id = $new_affiliate->id;
                            $economic->save();
                            $count_ecom++;
                        }
                        Log::info("economic comple");
                    }

                    //no hay registros en reimbursemenets
                    // $reimbursements = \Muserpol\Reimbursement::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($reimbursements->count()) {
                    //     Log::info("reimbursmene");
                    // }

                     $spouses = \Muserpol\Spouse::where('affiliate_id','=',$old_affiliate->id)->get();
                     if ($spouses->count()) {
                         foreach ($spouses as $spouse) {
                             $spouse->affiliate_id = $new_affiliate->id;
                             $spouse->save();
                             $count_spouse++;
                         }
                         Log::info("spouse");
                     }
                     //no hay registros en retirement_fund
                    // $retirement_funds = \Muserpol\RetirementFund::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($retirement_funds->count()) {
                    //     Log::info("retirememnt fun");
                    // }

                     //no hay registros en affiliate address
                    // $affiliate_address = \Muserpol\AffiliateAddress::where('affiliate_id','=',$old_affiliate->id)->get();
                    // if ($affiliate_address->count()) {
                    //     foreach ($affiliate_address as $address) {
                    //         $address->affiliate_id =  $new_affiliate->id;
                    //         $address->save();
                    //         $count++;
                    //     }
                    //     Log::info("affilate address");
                    // }

                     //no hay registros en vouchers
                    // $vouchers = \Muserpol\Voucher::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($vouchers->count()) {
                    //     Log::info("voucher");
                    // }
                    $new_affiliate->date_entry = $old_affiliate->date_entry;
                    if (!$new_affiliate->birth_date) {
                        $new_affiliate->birth_date=$old_affiliate->birth_date;
                    }
                    // $new_affiliate->identity_card=$old_affiliate->identity_card;
                    $new_affiliate->save();

                    $old_affiliate->delete();
                // }
        //     }
        // }

        $this->info('Afiliados Actualizados: '.$affi_count);
        $this->info('Total Activities '.$count_activities);
        $this->info('Total Observations '.$count_observations);
        $this->info('Total Contributions '.$count_contributions);
        $this->info('Total Records '.$count_records);
        $this->info('Total Complements '.$count_ecom);
        $this->info('Total Spouses '.$count_spouse);
    
    }
}
