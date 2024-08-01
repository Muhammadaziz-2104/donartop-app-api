<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodNeeds extends Model
{
    use HasFactory;

    protected $fillable = [
            'featured',
            'name',
            'blood_id',
            'city_id',
            'location_id',
            'user_id',
            'religion',
            'email',
            'phone',
            'profession',
            'details',
            'image',
            'address',
            'total_donate',
            'gender',
            'status',
            'birth_date',
            'last_donate',
            'socialMedia',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function blood()
    {
        return $this->belongsTo(Blood::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}

