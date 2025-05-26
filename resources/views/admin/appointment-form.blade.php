@extends('layouts.app')

@section('content')
    {{-- container na wszystko --}}
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($appointment) ? 'Edytuj wizytę' : 'Dodaj nową wizytę' }}
        </h2>

        {{-- komunikaty o bbędach --}}
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
            class="space-y-4">

            @csrf
            @if (isset($appointment))
                @method('PUT')
            @endif

            {{-- select do wybierania dentystow --}}
            <div>
                <label for="doctor_id" class="block text-sm font-medium text-gray-700">Lekarz</label>
                <select name="doctor_id" id="doctor_id" required
                    class="border p-2 rounded w-full @error('doctor_id') border-red-500 @enderror"
                    {{ isset($appointment) ? 'disabled' : '' }} aria-describedby="doctor_id-error"
                    @error('doctor_id') aria-invalid="true" @enderror>
                    <option value="">Wybierz lekarza</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                        </option>
                    @endforeach
                </select>
                @if (isset($appointment))
                    <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                @endif
                @error('doctor_id')
                    <span class="text-red-700 text-sm" id="doctor_id-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- select do wybierania pacjentow --}}
            <div>
                <label for="patient_id" class="block text-sm font-medium text-gray-700">Pacjent</label>
                <select name="patient_id" id="patient_id" required
                    class="border p-2 rounded w-full @error('patient_id') border-red-500 @enderror"
                    {{ isset($appointment) ? 'disabled' : '' }} aria-describedby="patient_id-error"
                    @error('patient_id') aria-invalid="true" @enderror>
                    <option value="">Wybierz pacjenta</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ old('patient_id', $appointment->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                        </option>
                    @endforeach
                </select>
                @if (isset($appointment))
                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                @endif
                @error('patient_id')
                    <span class="text-red-700 text-sm" id="patient_id-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- data wizyty --}}
            <div>
                <label for="appointment_date" class="block text-sm font-medium text-gray-700">Data wizyty</label>
                <input type="datetime-local" name="appointment_date" id="appointment_date"
                    value="{{ old('appointment_date', isset($appointment) ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') : '') }}"
                    required class="border p-2 rounded w-full @error('appointment_date') border-red-500 @enderror"
                    aria-describedby="appointment_date-error" @error('appointment_date') aria-invalid="true" @enderror>
                @error('appointment_date')
                    <span class="text-red-700 text-sm" id="appointment_date-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- status wizyty --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" required
                    class="border p-2 rounded w-full @error('status') border-red-500 @enderror"
                    aria-describedby="status-error" @error('status') aria-invalid="true" @enderror>
                    <option value="scheduled"
                        {{ old('status', $appointment->status ?? '') == 'scheduled' ? 'selected' : '' }}>Zaplanowana
                    </option>
                    <option value="completed"
                        {{ old('status', $appointment->status ?? '') == 'completed' ? 'selected' : '' }}>Zakończona
                    </option>
                    <option value="canceled"
                        {{ old('status', $appointment->status ?? '') == 'canceled' ? 'selected' : '' }}>Anulowana</option>
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
                    <option value="implantology"
                        {{ old('visit_type', $appointment->visit_type ?? '') == 'implantology' ? 'selected' : '' }}>
                        Implantologia</option>
                    <option value="orthodontics"
                        {{ old('visit_type', $appointment->visit_type ?? '') == 'orthodontics' ? 'selected' : '' }}>
                        Ortodoncja</option>
                    <option value="root_canal"
                        {{ old('visit_type', $appointment->visit_type ?? '') == 'root_canal' ? 'selected' : '' }}>Leczenie
                        kanałowe</option>
                    <option value="cavity_treatment"
                        {{ old('visit_type', $appointment->visit_type ?? '') == 'cavity_treatment' ? 'selected' : '' }}>
                        Leczenie próchnicy</option>
                </select>
                @error('visit_type')
                    <span class="text-red-700 text-sm" id="visit_type-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- notatki do wizyty --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notatki</label>
                <textarea name="notes" id="notes" class="border p-2 rounded w-full @error('notes') border-red-500 @enderror"
                    aria-describedby="notes-error" @error('notes') aria-invalid="true" @enderror>{{ old('notes', $appointment->notes ?? '') }}</textarea>
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
