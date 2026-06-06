<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address',
        'session_id',
        'url',
        'referrer',
        'country',
        'browser',
        'device_type',
        'user_agent',
    ];
}
