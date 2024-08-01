<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function bloodNeed()
    {
        return $this->belongsTo(BloodNeeds::class);
    }
    public function donar()
    {
        return $this->belongsTo(Donar::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
