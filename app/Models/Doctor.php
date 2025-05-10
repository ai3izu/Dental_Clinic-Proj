<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'specialization',
        'phone_number',
        'photo_url',
        'photo_alt',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
