<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'status',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function bloodNeeds()
    {
        return $this->hasMany(BloodNeeds::class);
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
