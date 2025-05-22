@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="max-w-2xl mx-auto mt-10 mb-20 bg-white shadow p-6 rounded-lg">
        <h2 class="text-2xl font-semibold text-[#13293D] mb-4">Notatki z wizyty</h2>

        <p class="text-gray-700 mb-2">
            <strong>Pacjent:</strong> {{ $appointment->patient->user->first_name }}
            {{ $appointment->patient->user->last_name }}
        </p>
        <p class="text-gray-700 mb-4">
            <strong>Data wizyty:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}
        </p>

        <form method="POST" action="{{ route('doctor.appointments.notes', $appointment->id) }}">
            @csrf
            <div class="mb-4">
                <label for="notes" class="block text-[#13293D] font-medium mb-1">Notatki:</label>
                <textarea name="notes" id="notes" rows="5" class="w-full border p-2 rounded" placeholder="Wpisz notatki...">{{ old('notes', $appointment->notes) }}</textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('doctor.dashboard') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Anuluj
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Zapisz notatki
                </button>
            </div>
        </form>
    </div>
@endsection
