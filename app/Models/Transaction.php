<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_date',
        'status',
        'notes',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
