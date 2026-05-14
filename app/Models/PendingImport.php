<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingImport extends Model
{
     protected $fillable = [
        'type',
        'status',
        'result',
    ];

    protected $casts = [
        'result' => 'array',
    ];
}
