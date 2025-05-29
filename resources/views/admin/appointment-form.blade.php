@extends('layouts.app')

@section('content')
    {{-- container na wszystko --}}
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($appointment) ? 'Edytuj wizytę' : 'Dodaj nową wizytę' }}
        </h2>

        {{-- komunikaty o błędach --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Wystąpiły błędy!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- caly fomularz --}}
        <form method="POST"
            action="{{ isset($appointment) ? route('admin.appointments.update', $appointment->id) : route('admin.appointments.store') }}"
            class="space-y-4" x-data="{
                        selectedDoctor: '{{ old('doctor_id', $appointment->doctor_id ?? '') }}',
                        selectedDate: '{{ old('date', isset($appointment) ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}',
                        selectedTime: '{{ old('time', isset($appointment) ? \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') : '') }}',
                        availableTimes: [],

                        fetchAvailableTimes() {
                            if (!this.selectedDate || !this.selectedDoctor) {
                                this.availableTimes = [];
                                this.selectedTime = '';
                                return;
                            }
                            fetch(`{{ route('admin.appointments.available_slots') }}?date=${this.selectedDate}&doctor_id=${this.selectedDoctor}`)
                                .then(response => response.json())
                                .then(data => {
                                    this.availableTimes = data;
                                    // Jeśli aktualnie wybrany czas nie jest już dostępny, wybierz pierwszy dostępny lub wyczyść
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
                    }"
            x-init="fetchAvailableTimes(); $watch('selectedDate', () => fetchAvailableTimes()); $watch('selectedDoctor', () => fetchAvailableTimes())">

            @csrf
            @if (isset($appointment))
                @method('PUT')
            @endif

            {{-- select do wybierania dentystow --}}
            <div>
                <label for="doctor_id" class="block text-sm font-medium text-gray-700">Lekarz</label>
                <select name="doctor_id" id="doctor_id" required
                    class="border p-2 rounded w-full @error('doctor_id') border-red-500 @enderror"
                    aria-describedby="doctor_id-error" @error('doctor_id') aria-invalid="true" @enderror
                    x-model="selectedDoctor">
                    <option value="">Wybierz lekarza</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <span class="text-red-700 text-sm" id="doctor_id-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- select do wybierania pacjentow --}}
            <div>
                <label for="patient_id" class="block text-sm font-medium text-gray-700">Pacjent</label>
                <select name="patient_id" id="patient_id" required
                    class="border p-2 rounded w-full @error('patient_id') border-red-500 @enderror"
                    aria-describedby="patient_id-error" @error('patient_id') aria-invalid="true" @enderror>
                    <option value="">Wybierz pacjenta</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ old('patient_id', $appointment->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                    <span class="text-red-700 text-sm" id="patient_id-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- data wizyty --}}
            <div>
                <label for="date_input" class="block text-sm font-medium text-gray-700">Data wizyty</label>
                <input type="date" name="date" id="date_input" x-model="selectedDate" min="{{ now()->format('Y-m-d') }}"
                    class="border p-2 rounded w-full @error('date') border-red-500 @enderror" aria-describedby="date-error"
                    @error('date') aria-invalid="true" @enderror>
                @error('date')
                    <span class="text-red-700 text-sm" id="date-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- godzina wizyty --}}
            <div>
                <label for="time_input" class="block text-sm font-medium text-gray-700">Godzina wizyty</label>
                <select name="time" id="time_input" x-model="selectedTime" required
                    class="border p-2 rounded w-full @error('time') border-red-500 @enderror" aria-describedby="time-error"
                    @error('time') aria-invalid="true" @enderror>
                    <template x-for="timeSlot in availableTimes" :key="timeSlot">
                        <option :value="timeSlot" x-text="timeSlot"></option>
                    </template>
                    <template x-if="availableTimes.length === 0">
                        <option disabled value="">Brak wolnych terminów</option>
                    </template>
                </select>
                @error('time')
                    <span class="text-red-700 text-sm" id="time-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- ukryte pole dla pełnej daty i godziny, wysyłane do kontrolera --}}
            <input type="hidden" name="appointment_date" :value="selectedDate + ' ' + selectedTime">


            {{-- status wizyty --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" required
                    class="border p-2 rounded w-full @error('status') border-red-500 @enderror"
                    aria-describedby="status-error" @error('status') aria-invalid="true" @enderror>
                    @foreach (__('db.appointment_statuses') as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('status', $appointment->status ?? '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-red-700 text-sm" id="status-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- typ wizyty --}}
            <div>
                <label for="visit_type" class="block text-sm font-medium text-gray-700">Typ wizyty</label>
                <select name="visit_type" id="visit_type" required
                    class="border p-2 rounded w-full @error('visit_type') border-red-500 @enderror"
                    aria-describedby="visit_type-error" @error('visit_type') aria-invalid="true" @enderror>
                    @foreach (__('db.visit_types') as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('visit_type', $appointment->visit_type ?? '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('visit_type')
                    <span class="text-red-700 text-sm" id="visit_type-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- notatki do wizyty --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notatki</label>
                <textarea name="notes" id="notes" class="border p-2 rounded w-full @error('notes') border-red-500 @enderror"
                    aria-describedby="notes-error" @error('notes') aria-invalid="true"
                    @enderror>{{ old('notes', $appointment->notes ?? '') }}</textarea>
                @error('notes')
                    <span class="text-red-700 text-sm" id="notes-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- przyciski --}}
            <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#236DAA] hover:bg-[#1E5A90] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
                    {{ isset($appointment) ? 'Zapisz zmiany' : 'Dodaj wizytę' }}
                </button>

                <a href="{{ route('admin.dashboard', ['tab' => 'appointments']) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-[#13293D] font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base text-center">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
@endsection