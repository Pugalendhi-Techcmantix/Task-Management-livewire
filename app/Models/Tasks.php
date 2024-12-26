<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id'); // Use belongsTo and specify the correct foreign key
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Use belongsTo and specify the correct foreign key
    }

    public function getStatusLabelAttribute()
    {
        // Set label based on the status value
        $statusLabel = match ($this->status) {
            1 => 'Pending',
            2 => 'Progress',
            3 => 'Hold',
            4 => 'Completed',
            default => 'Unknown',
        };

        return [
            'status' => $statusLabel,
        ];
    }
}
