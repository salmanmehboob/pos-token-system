<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'comp_name',
        'comp_address',
        'comp_phone',
        'comp_mobile',
        'comp_email',
        'comp_logo',
    ];
}