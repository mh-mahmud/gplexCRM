<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'email_queue';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
