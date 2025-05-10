<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'appointment_id',
        'amount',
        'status',
        'payment_date',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function doctor()
    {
        return $this->appointment->doctor;
    }

    public function patient()
    {
        return $this->appointment->patient();
    }
}
