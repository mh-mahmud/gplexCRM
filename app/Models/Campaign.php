<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $table = 'campaigns';
    protected $fillable = [
        'form_id','campaign_title', 'start_date', 'end_date', 'description', 'campaign_type', 'campaign_limit', 'campaign_service', 'status', 'promotion_id'
    ];

    public function promotion()
    {
        return $this->belongsTo('App\Promotion');
    }
   
}
