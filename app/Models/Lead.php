<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
       
       protected $table = 'leads';
       protected $fillable = [
           'form_id',
           'first_name',
           'last_name',
           'email',
           'phone',
           'alternative_number',
           'gender',
           'dob',
           'marital_status',
           'address',
           'age',
           'company',
           'lead_status',
           'title',
           'lead_rating',
           'website',
           'lead_owner',
           'industry',
           'no_of_employee',
           'lead_source',
           'street',
           'city',
           'zip',
           'state',
           'country',
           'lead_notes',
       ];

       public function leadsForm()
    {
        return $this->belongsTo(LeadsForm::class, 'form_id', 'form_id');
    }
}
