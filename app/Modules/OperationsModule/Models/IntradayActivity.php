<?php

namespace App\Modules\OperationsModule\Models;

use Illuminate\Database\Eloquent\Model;

class IntradayActivity extends Model
{
    protected $fillable = ['name', 'code', 'color', 'is_paid'];

    protected $casts = [
        'is_paid' => 'boolean',
    ];
}
