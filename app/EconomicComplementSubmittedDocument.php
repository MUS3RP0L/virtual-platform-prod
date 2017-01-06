<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementSubmittedDocument extends Model
{
  protected $table = 'eco_com_submitted_documents';

  protected $fillable = [
    'eco_com_requirements',
    'economic_complement_id',
    'reception_date',
    'status',
    'comment'
  ];
  protected $guarded = ['id'];
}
