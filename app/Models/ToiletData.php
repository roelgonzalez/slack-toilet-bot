<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToiletData extends Model
{
    use HasFactory;

    protected $fillable = [
        'motion',
        'tamper',
        'battery',
        'lux',
        'temperature',
    ];

    protected $casts = [
        'motion' => 'boolean',
        'tamper' => 'boolean',
    ];
}
