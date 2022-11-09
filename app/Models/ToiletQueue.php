<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToiletQueue extends Model
{
    use HasFactory;

    protected $table = 'toilet-queues';

    protected $fillable = [
        'channel_id',
        'user_name',
    ];
}
