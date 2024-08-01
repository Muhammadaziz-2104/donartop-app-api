<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodCenter extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'address',
            'director',
            'work_time',
            'phone',
            'phone2',
            'email',
            'location',
        ];
}
