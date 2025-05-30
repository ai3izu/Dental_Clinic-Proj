<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_date',
        'status',
        'visit_type',
        'notes',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function isPaid(): bool
    {
        return $this->transaction?->status === 'paid';
    }
}
