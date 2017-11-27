<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;
use Muserpol\Affiliate;

class FusionAffiliate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fusion:affiliate_2';

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
        
        $new_affi_with_ext=Affiliate::where('identity_card','like','%-%')->get();
        $affiliates_all=Affiliate::all();
        $count=0;
        $affi_count=0;
        $count_activities=0;
        $count_observations=0;
        $count_contributions=0;
        $count_records=0;
        foreach ($affiliates_all as $old_affiliate) {
            foreach ($new_affi_with_ext as $new_affiliate) {
                if ($old_affiliate->identity_card == explode('-', $new_affiliate->identity_card)[0]) {
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
                     $economic_complements   }
                        Log::info("Affiliate Observations");
                    }
                    $contributions = \Muserpol\Contribution::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($contributions->count()) {
                        foreach ($contributions as $cont) {
                            $cont->affiliate_id = $new_affiliate->id;
                            $cont->save();
                            $count_contributions++;
                     $economic_complements   }
                        Log::info("contributions");
                    }
                    $affiliate_records = \Muserpol\AffiliateRecord::where('affiliate_id','=',$old_affiliate->id)->get();
                    if ($affiliate_records->count()) {
                        foreach ($affiliate_records as $affirecord) {
                            $affirecord->affiliate_id=$new_affiliate->id;
                            $affirecord->save();
                            $count_records++;
                     $economic_complements   }
                        Log::info("affiliate records");
                    }
                    // $direct_contributions = \Muserpol\DirectContribution::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($direct_contributions->count()) {
                    //     Log::info("direct COntr");
                    // }
                    // $economic_complements = \Muserpol\EconomicComplement::where('affiliate_id','=',$old_affiliate->id)->get();
                    // if ($economic_complements->count()) {
                    //     foreach ($economic_complements as $economic) {
                    //         $economic->affiliate_id = $new_affiliate->id;
                    //         $economic->save();
                    /$economic_complements/         $count++;
                    //     }
                    //     Log::info("economic comple");
                    // }
                    // $reimbursements = \Muserpol\Reimbursement::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($reimbursements->count()) {
                    //     Log::info("reimbursmene");
                    // }
                    // $spouses = \Muserpol\Spouse::where('affiliate_id','=',$old_affiliate->id)->get();
                    // if ($spouses->count()) {
                    //     foreach ($spouses as $spouse) {
                    //         $spouse->affiliate_id = $new_affiliate->id;
                    //         $spouse->save();
                    //         $count++;
                    //     }
                    //     Log::info("spouse");
                    // }
/*                    $retirement_funds = \Muserpol\RetirementFund::where('affiliate_id','=',$affiliate->id)->get();
                    if ($retirement_funds->count()) {
                        Log::info("retirememnt fun");
                    }*/
                    // $affiliate_address = \Muserpol\AffiliateAddress::where('affiliate_id','=',$old_affiliate->id)->get();
                    // if ($affiliate_address->count()) {
                    //     foreach ($affiliate_address as $address) {
                    //         $address->affiliate_id =  $new_affiliate->id;
                    //         $address->save();
                    //         $count++;
                    //     }
                    //     Log::info("affilate address");
                    // }
                    // $vouchers = \Muserpol\Voucher::where('affiliate_id','=',$affiliate->id)->get();
                    // if ($vouchers->count()) {
                    //     Log::info("voucher");
                    // }


                    // if (Affiliate::IdIs($affiliate->id)->first()->economic_complements->count()) {
                    //     $count_trami++;
                    //     $this->info($affi->id." ".$affiliate->id." ".$affi->identity_card." ".$affiliate->identity_card);
                    // }else{
                    //     $count_no_trami++;
                    // }
                    // $new = Affiliate::IdIs($new_affiliate->id)->first();
                    $new_affiliate->date_entry = $old_affiliate->date_entry;
                    if (!$new_affiliate->birth_date) {
                        $new_affiliate->birth_date=$old_affiliate->birth_date;
                    }
                    $new_affiliate->save();

                    $old_affiliate->delete();
                }
            }
        }

        $this->info('Afiliados Actualizados: '.$affi_count);
        $this->info('Total Activities '.$count_activities);
        $this->info('Total Observations '.$count_observations);
        $this->info('Total Contributions '.$count_contributions);
        $this->info('Total Records '.$count_records);
        $dcount=0;
        $affi_with_ext_one=Affiliate::where('identity_card','like','%-%')->get();
        $affi_with_ext_two=Affiliate::where('identity_card','like','%-%')->get();
        foreach ($affi_with_ext_one as $affi_one) {
            foreach ($affi_with_ext_two as $affi_two) {
                if ($affi_one->id <> $affi_two->id && explode('-',$affi_one->identity_card)[0] == explode('-',$affi_two->identity_card)[0] ) {
                    $min_id=min($affi_one->id, $affi_two->id);
                    $max_id=max($affi_one->id, $affi_two->id);
                        $activities = \Muserpol\Activity::where('affiliate_id','=',$min_id)->get();
                        if ($activities->count()) {
                            foreach ($activities as $activitie) {
                                $activitie->affiliate_id = $max_id;
                                $activitie->save();
                                $count_activities++;
                            }
                            Log::info("activities");
                        }
                        $affiliate_observations = \Muserpol\AffiliateObservation::where('affiliate_id','=',$min_id)->get();
                        if ($affiliate_observations->count()) {
                            foreach ($affiliate_observations as $affobs) {
                                $affobs->affiliate_id = $max_id;
                                $affobs->save();
                                $count_observations++;
                            }
                            Log::info("Affiliate Observations");
                        }
                        $contributions = \Muserpol\Contribution::where('affiliate_id','=',$min_id)->get();
                        if ($contributions->count()) {
                            foreach ($contributions as $cont) {
                                $cont->affiliate_id = $max_id;
                                $cont->save();
                                $count_contributions++;
                            }
                            Log::info("contributions");
                        }
                        $affiliate_records = \Muserpol\AffiliateRecord::where('affiliate_id','=',$min_id)->get();
                        if ($affiliate_records->count()) {
                            foreach ($affiliate_records as $affirecord) {
                                $affirecord->max_id;
                                $affirecord->save();
                                $count_records++;
                            }
                            Log::info("affiliate records");
                        }
                        $economic_complements = \Muserpol\EconomicComplement::where('affiliate_id','=',$min_id)->get();
                        if ($economic_complements->count()) {
                            foreach ($economic_complements as $economic) {
                                $economic->affiliate_id = $max_id;
                                $economic->save();
                                $count++;
                            }
                            Log::info("economic comple");
                        }
                        $spouses = \Muserpol\Spouse::where('affiliate_id','=',$min_id)->get();
                        if ($spouses->count()) {
                            foreach ($spouses as $spouse) {
                                $spouse->affiliate_id = $max_id;
                                $spouse->save();
                                $count++;
                            }
                            Log::info("spouse");
                        }
                        if ($affi_one->id > $affi_two->id) {
                            $affi_one->birth_date = $affi_two->birth_date;
                            $affi_one->date_entry = $affi_two->date_entry;
                            $affi_one->save();
                            $affi_two->delete();
                        }else{
                            $affi_two->birth_date = $affi_one->birth_date;
                            $affi_two->date_entry = $affi_one->date_entry;
                            $affi_two->save();
                            $affi_one->delete();
                        }
                        $dcount++;
                }
            }
        }
    $this->info("total afiliados con extension distinto". $dcount/2);
    }
}
