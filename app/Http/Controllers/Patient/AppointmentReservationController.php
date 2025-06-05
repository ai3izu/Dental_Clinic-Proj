<?php

namespace App\Http\Controllers\Patient;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AppointmentReservationController
{
    /**
     * Mapowanie specjalizacji na dostępne typy wizyt.
     * Używane zarówno w create() do widoku, jak i w store() do walidacji.
     * @var array
     */
    private $specializationVisitTypes = [
        'Chirurg stomatologiczny' => ['root_canal', 'implantology'],
        'Dentysta ogólny' => ['cavity_treatment', 'root_canal', 'orthodontics'],
        'Stomatolog dziecięcy' => ['cavity_treatment'],
        'Ortodonta' => ['orthodontics'],
    ];

    public function create(Doctor $doctor)
    {
        $filteredVisitTypes = $this->specializationVisitTypes[$doctor->specialization] ?? [];
        $availableSlots = collect();

        return view(
            'patient.apointment-reservation',
            compact('doctor', 'availableSlots', 'filteredVisitTypes')
        );
    }

    public function store(Request $request)
    {
        $appointmentDate = Carbon::parse($request->date . ' ' . $request->time);
        $doctor = Doctor::where('id', $request->doctor_id)->firstOrFail();

        $allowedVisitTypes = $this->specializationVisitTypes[$doctor->specialization] ?? [];

        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'visit_type' => ['required', 'string', 'max:255', Rule::in($allowedVisitTypes)],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i'],
        ]);

        if ($appointmentDate->isBefore(Carbon::now()->subMinutes(5))) {
            return back()->withErrors(['date' => 'Wybrana data i godzina wizyty musi być w przyszłości.'])->withInput();
        }

        if ($appointmentDate->hour < 9 || $appointmentDate->hour > 17 || $appointmentDate->minute !== 0) {
            return back()->withErrors(['time' => 'Godzina wizyty musi być pełną godziną między 09:00 a 17:00.'])->withInput();
        }

        $availableSlotsForValidation = $this->getAvailableSlotsCalculated(
            Carbon::parse($request->date),
            $doctor,
            Auth::user()->patient->id
        );

        if (!in_array($request->time, $availableSlotsForValidation->toArray())) {
            return back()->withErrors(['time' => 'Wybrana godzina jest już zajęta lub niedostępna. Proszę wybrać inny termin.'])->withInput();
        }

        $existingDoctorAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDate)
            ->where('status', 'scheduled')
            ->first();

        if ($existingDoctorAppointment) {
            return back()->withErrors(['time' => 'Wybrana godzina jest już zajęta u tego lekarza w tym dniu. Proszę wybrać inny termin.'])->withInput();
        }

        $patientExistingAppointment = Appointment::where('patient_id', Auth::user()->patient->id)
            ->where('appointment_date', $appointmentDate)
            ->where('status', 'scheduled')
            ->first();

        if ($patientExistingAppointment) {
            return back()->withErrors(['time' => 'Masz już zaplanowaną inną wizytę na tę datę i godzinę. Proszę wybrać inny termin.'])->withInput();
        }

        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'visit_type' => $request->visit_type,
            'appointment_date' => $appointmentDate,
            'status' => 'scheduled',
            'notes' => null,
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Wizyta została zaplanowana.');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $date = Carbon::parse($request->date);
        $doctor = Doctor::where('id', $request->doctor_id)->firstOrFail();
        $patientId = Auth::user()->patient->id;

        $availableSlots = $this->getAvailableSlotsCalculated($date, $doctor, $patientId);

        return response()->json($availableSlots);
    }

    private function getAvailableSlotsCalculated(Carbon $date, Doctor $doctor, int $patientId)
    {
        $startOfDay = $date->copy()->hour(9)->minute(0)->second(0);
        $endOfDay = $date->copy()->hour(17)->minute(0)->second(0);

        $allPossibleSlots = CarbonPeriod::create($startOfDay, '60 minutes', $endOfDay)->toArray();

        $takenSlotsByDoctor = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date)
            ->where('status', 'scheduled')
            ->pluck('appointment_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('H:i');
            })
            ->toArray();

        $takenSlotsByPatient = Appointment::where('patient_id', $patientId)
            ->whereDate('appointment_date', $date)
            ->where('status', 'scheduled')
            ->pluck('appointment_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('H:i');
            })
            ->toArray();

        $allTakenSlots = array_merge($takenSlotsByDoctor, $takenSlotsByPatient);
        $now = Carbon::now();

        $availableSlots = collect($allPossibleSlots)->filter(function ($slot) use ($allTakenSlots, $now, $date) {
            if ($slot->isSameDay($now)) {
                $isAfterNow = $slot->isAfter($now->copy()->addMinutes(5));
                $isTaken = in_array($slot->format('H:i'), $allTakenSlots);
                return $isAfterNow && !$isTaken;
            }
            return !in_array($slot->format('H:i'), $allTakenSlots);
        })->map(function ($slot) {
            return $slot->format('H:i');
        })->values();

        return $availableSlots;
    }
}
