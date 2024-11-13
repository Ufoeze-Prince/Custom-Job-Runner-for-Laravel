<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    use HasFactory;

    // Specify the table name if it's not following Laravel's plural convention
    protected $table = 'job_logs';

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'class',
        'method',
        'params',
        'priority',
        'status',
    ];

    // Cast params to an array when retrieved
    protected $casts = [
        'params' => 'array',
    ];
}
