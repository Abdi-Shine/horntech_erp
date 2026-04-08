<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'areas_of_interest' => 'array',
        'preferred_date'    => 'date',
    ];
}
