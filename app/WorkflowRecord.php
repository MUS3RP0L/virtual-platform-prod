<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Util;
use Log;
use Carbon\Carbon;

class WorkflowRecord extends Model
{
    protected $table = 'wf_records';
    protected $fillable = [
        'date',
        'user_id',
        'wf_step_id',
        'eco_com_id',
        'ret_fun_id',
        'message'
    ];

    protected $guarded = ['id'];

    public function wf_step()
    {
        return $this->belongsTo(WorkflowStep::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function creatingEconomicComplement($economic_complement)
    {
        if (Auth::user()) {
            $wf_record=new WorkflowRecord;
            $wf_record->user_id=Auth::user()->id ?? 1;
            $wf_record->date=Carbon::now();
            $wf_record->eco_com_id=$economic_complement->id;
            $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
            $wf_record->record_type_id=1;
            $wf_record->message="El usuario ".Util::getFullNameuser()." creó el trámite ".$economic_complement->code." en fecha ".Carbon::now().".";
            $wf_record->save();
        }
    }
    public static function updatedEconomicComplement($economic_complement)
    {
        Log::info("IN with".$economic_complement->id);
        if (Auth::user()) {
            $old_economic_complement=EconomicComplement::find($economic_complement->id);
            if ( $old_economic_complement->state <> $economic_complement->state && $economic_complement->state<>'Received') {
                $wf_record=new WorkflowRecord;
                $wf_record->user_id=Auth::user()->id ?? 1;
                $wf_record->date=Carbon::now();
                $wf_record->eco_com_id=$economic_complement->id;
                $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                $wf_record->record_type_id=1;
                $wf_record->message="El usuario ".Util::getFullNameuser()." ".Util::wfStateName($economic_complement->wf_current_state_id)." el trámite ".$economic_complement->code." en fecha ".Carbon::now().".";
                $wf_record->save();
            }

            if ($old_economic_complement->wf_current_state_id <> $economic_complement->wf_current_state_id) {
                $wf_record=new WorkflowRecord;
                $wf_record->user_id=Auth::user()->id ?? 1;
                $wf_record->date=Carbon::now();
                $wf_record->eco_com_id=$economic_complement->id;
                $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                $wf_record->record_type_id=1;

                if ($economic_complement->eco_com_state_id == 1 || $economic_complement->eco_com_state_id == 2 || $economic_complement->eco_com_state_id == 3 || $economic_complement->eco_com_state_id == 17 || $economic_complement->eco_com_state_id == 18 || $economic_complement->eco_com_state_id == 15) {
                    $wf_record->message="El usuario ".Util::getFullNameuser()." derivo el tramite ".$economic_complement->code." de ".$old_economic_complement->wf_state->name." a ".$economic_complement->wf_state->name." en fecha ".Carbon::now().",  (Por una recalificacion )";
                }else{
                    $wf_record->message="El usuario ".Util::getFullNameuser()." derivo el tramite ".$economic_complement->code." de ".$old_economic_complement->wf_state->name." a ".$economic_complement->wf_state->name." en fecha ".Carbon::now().".";
                }
                $wf_record->save();
            }
            if ($old_economic_complement->degree_id <> $economic_complement->degree_id) {
                Log::info("degree");
                $wf_record = new WorkflowRecord;
                $wf_record->user_id = Auth::user()->id ?? 1;
                $wf_record->date = Carbon::now();
                $wf_record->eco_com_id = $economic_complement->id;
                $wf_record->wf_state_id = $economic_complement->wf_current_state_id;
                $wf_record->record_type_id = 1;
                $wf_record->message = "El usuario " . Util::getFullNameuser() . " actualizó  el grado de " . ($old_economic_complement->degree->name ?? 'sin grado') . " a " . $economic_complement->degree->name . " del trámite ". $economic_complement->code . " en fecha " . Carbon::now() . ".";
                $wf_record->save();
            }
            if ($old_economic_complement->category_id <> $economic_complement->category_id) {
                Log::info("category");
                $wf_record = new WorkflowRecord;
                $wf_record->user_id = Auth::user()->id ?? 1;
                $wf_record->date = Carbon::now();
                $wf_record->eco_com_id = $economic_complement->id;
                $wf_record->wf_state_id = $economic_complement->wf_current_state_id;
                $wf_record->record_type_id = 1;
                $wf_record->message = "El usuario " . Util::getFullNameuser() . " actualizó  la categoría de " . ($old_economic_complement->category->name ?? 'sin categoría') . " a " . $economic_complement->category->name . " del trámite ". $economic_complement->code . " en fecha " . Carbon::now() . ".";
                $wf_record->save();
            }
            // if ($old_economic_complement->   <> $economic_complement->total && ($old_economic_complement->total > 0 && ($old_economic_complement->eco_com_state_id == 1 || $old_economic_complement->eco_com_state_id == 2 || $old_economic_complement->eco_com_state_id == 3 || $old_economic_complement->eco_com_state_id == 17 || $old_economic_complement->eco_com_state_id == 18 || $old_economic_complement->eco_com_state_id == 15)) ) {
            //     Log::info("total");
            //     $wf_record = new WorkflowRecord;
            //     $wf_record->user_id = Auth::user()->id ?? 1;
            //     $wf_record->date = Carbon::now();
            //     $wf_record->eco_com_id = $economic_complement->id;
            //     $wf_record->wf_state_id = $economic_complement->wf_current_state_id;
            //     $wf_record->record_type_id = 1;
            //     $wf_record->message = "El usuario " . Util::getFullNameuser() . " recalifico el trámite ". $economic_complement->code . " en fecha " . Carbon::now() . ".";
            //     $wf_record->save();
            // }
        }
    }
}
