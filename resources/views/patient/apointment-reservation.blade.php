@extends('layouts.app')

@section('title', 'Umów wizytę')

@section('content')
    <div class="max-w-xl mx-auto mt-12 mb-16 p-6 bg-white rounded-xl shadow-md" aria-labelledby="appointment-heading">
        <h2 id="appointment-heading" class="text-2xl font-semibold text-[#13293D] mb-6">Umów wizytę z dr
            {{ $doctor->user->first_name }}
            {{ $doctor->user->last_name }}
        </h2>

        <form action="{{ route('patient.appoitment.store') }}" method="POST" class="space-y-4" x-data="{
            selectedDate: '{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}',
            selectedTime: '{{ old('time', '') }}',
            availableTimes: [],
            doctorId: {{ $doctor->id }},
        
            fetchAvailableTimes() {
                if (!this.selectedDate) {
                    this.availableTimes = [];
                    this.selectedTime = '';
                    return;
                }
                fetch(`{{ route('patient.appointments.available_slots') }}?date=${this.selectedDate}&doctor_id=${this.doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        this.availableTimes = data;
                        if (!this.availableTimes.includes(this.selectedTime)) {
                            if (this.availableTimes.length > 0) {
                                this.selectedTime = this.availableTimes[0];
                            } else {
                                this.selectedTime = '';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Błąd podczas pobierania dostępnych godzin:', error);
                        this.availableTimes = [];
                        this.selectedTime = '';
                    });
            },
            init() {
                this.$watch('selectedDate', () => this.fetchAvailableTimes());
                this.fetchAvailableTimes();
            }
        }">
            @csrf

            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Data wizyty:</label>
                <input type="date" id="date" name="date" x-model="selectedDate"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" required>
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Godzina wizyty:</label>
                <select id="time" name="time" x-model="selectedTime"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" aria-label="Wybierz godzinę wizyty"
                    aria-describedby="time-error" required>
                    <template x-for="time in availableTimes" :key="time">
                        <option :value="time" x-text="time"></option>
                    </template>
                    <template x-if="availableTimes.length === 0">
                        <option value="" disabled>Brak dostępnych godzin</option>
                    </template>
                </select>
                @error('time')
                    <p class="text-red-500 text-sm mt-1" id="time-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="visit_type" class="block text-sm font-medium text-gray-700 mb-1">Typ wizyty:</label>
                <select id="visit_type" name="visit_type" class="mt-1 block w-full border-gray-300 rounded-md p-2"
                    aria-label="Wybierz typ wizyty" aria-describedby="visit-type-error" required>
                    @foreach ($filteredVisitTypes as $typeValue)
                        <option value="{{ $typeValue }}" {{ old('visit_type') == $typeValue ? 'selected' : '' }}>
                            {{ __("db.visit_types.{$typeValue}") }}
                        </option>
                    @endforeach
                    @if (empty($filteredVisitTypes))
                        <option value="" disabled selected>Brak dostępnych usług dla tego lekarza</option>
                    @endif
                </select>
                @error('visit_type')
                    <p class="text-red-500 text-sm mt-1" id="visit-type-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#3E92CC] text-white py-2 px-4 rounded-md hover:bg-[#327db4]"
                aria-label="Zarezerwuj wizytę u dentysty">
                Zarezerwuj wizytę
            </button>
        </form>

        <a href="{{ route('patient.dashboard') }}"
            class="mt-4 block w-full text-center bg-gray-300 text-black py-2 px-4 rounded-md hover:bg-gray-400">
            Wróć do panelu pacjenta
        </a>
    </div>
@endsection
