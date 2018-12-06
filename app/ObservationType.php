<?php

namespace Muserpol;

use Cron\AbstractField;
use Illuminate\Database\Eloquent\Model;

class ObservationType extends Model
{
    protected $table = 'observation_types';

    protected $fillable = [
        'module_id',
        'name',
        'description',
        'type'
    ];
    protected $guarded = ['id'];

    public $timestamps = false;

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function affiliateObservations()
    {
        return $this->hasMany(AffiliateObservation::class);
    }
}
