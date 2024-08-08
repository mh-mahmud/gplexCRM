<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $fillable = ['subject', 'customer_id', 'status', 'start_date', 'end_date'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
