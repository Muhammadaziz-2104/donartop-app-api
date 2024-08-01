<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

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
