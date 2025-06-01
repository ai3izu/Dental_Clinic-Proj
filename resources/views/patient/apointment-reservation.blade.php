@extends('layouts.app')

@section('title', 'Umów wizytę')

@section('content')
    <div class="max-w-xl mx-auto mt-12 mb-16 p-6 bg-white rounded-xl shadow-md" **aria-labelledby="appointment-heading" **>
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
                    }
                }" x-init="fetchAvailableTimes();
                    $watch('selectedDate', () => fetchAvailableTimes())" **aria-label="Formularz umawiania wizyty" **>

            @csrf
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}" **aria-hidden="true" **>

            <div>
                <label for="date" class="block font-medium text-gray-700">Data wizyty</label>
                <input type="date" id="date" name="date" x-model="selectedDate" min="{{ now()->format('Y-m-d') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2" required
                    **aria-label="Wybierz datę wizyty" aria-describedby="date-error" **>
                @error('date')
                    <p class="text-red-500 text-sm mt-1" id="date-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="time" class="block font-medium text-gray-700">Godzina wizyty</label>
                <select name="time" id="time" x-model="selectedTime"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 overflow-y-auto" required
                    **aria-label="Wybierz godzinę wizyty" aria-describedby="time-error" **>
                    <template x-for="timeSlot in availableTimes" :key="timeSlot">
                        <option :value="timeSlot" x-text="timeSlot"></option>
                    </template>
                    <template x-if="availableTimes.length === 0">
                        <option disabled value="">Brak wolnych terminów</option>
                    </template>
                </select>
                @error('time')
                    <p class="text-red-500 text-sm mt-1" id="time-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="visit_type" class="block font-medium text-gray-700">Typ wizyty</label>
                <select id="visit_type" name="visit_type" required
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2" **aria-label="Wybierz typ wizyty"
                    aria-describedby="visit-type-error" **>
                    <option value="implantology" {{ old('visit_type') == 'implantology' ? 'selected' : '' }}>Implantologia
                    </option>
                    <option value="cavity_treatment" {{ old('visit_type') == 'cavity_treatment' ? 'selected' : '' }}>
                        Leczenie próchnicy</option>
                    <option value="orthodontics" {{ old('visit_type') == 'orthodontics' ? 'selected' : '' }}>Ortodoncja
                    </option>
                    <option value="root_canal" {{ old('visit_type') == 'root_canal' ? 'selected' : '' }}>Leczenie kanałowe
                    </option>
                </select>
                @error('visit_type')
                    <p class="text-red-500 text-sm mt-1" id="visit-type-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#3E92CC] text-white py-2 px-4 rounded-md hover:bg-[#327db4]"
                **aria-label="Zarezerwuj wizytę u dentysty" **>
                Zarezerwuj wizytę
            </button>
        </form>

        <a href="{{ route('patient.dashboard') }}"
            class="mt-4 block w-full text-center bg-gray-300 text-black py-2 px-4 rounded-md hover:bg-gray-400"
            **aria-label="Anuluj i wróć do panelu pacjenta" **>
            Anuluj i wróć do dashboardu
        </a>
    </div>
@endsection