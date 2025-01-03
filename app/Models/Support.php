<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;
    protected $table = 'support';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Use belongsTo and specify the correct foreign key
    }
}
