<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Util;
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
            $wf_record->message="El usuario ".Util::getFullNameuser()." creo el tramite ".$economic_complement->code." en fecha ".Carbon::now().".";
            $wf_record->save();
        }
    }
    public static function updatedEconomicComplement($economic_complement)
    {
        if (Auth::user()) {
            $old_economic_complement=EconomicComplement::find($economic_complement->id);
            if ($old_economic_complement->wf_current_state_id <> $economic_complement->wf_current_state_id) {
                $wf_record=new WorkflowRecord;
                $wf_record->user_id=Auth::user()->id ?? 1;
                $wf_record->date=Carbon::now();
                $wf_record->eco_com_id=$economic_complement->id;
                $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                $wf_record->record_type_id=1;
                $wf_record->message="El usuario ".Util::getFullNameuser()." derivo el tramite ".$economic_complement->code." de ".$old_economic_complement->wf_state->name." a ".$economic_complement->wf_state->name." en fecha ".Carbon::now().".";
                $wf_record->save();
            }
        }
    }
}
