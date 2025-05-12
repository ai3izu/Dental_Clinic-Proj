@extends('layouts.app')

@section('title', 'Umów wizytę')

@section('content')
    <div class="max-w-xl mx-auto mt-12 mb-16 p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold text-[#13293D] mb-6">Umów wizytę z dr {{ $doctor->user->first_name }}
            {{ $doctor->user->last_name }}</h2>

        <form action="{{ route('patient.appoitment.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

            <div>
                <label for="date" class="block font-medium text-gray-700">Data wizyty</label>
                <input type="date" id="date" name="date" value="{{ now()->format('Y-m-d') }}"
                    min="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    required>
            </div>

            <div>
                <label for="time" class="block font-medium text-gray-700">Godzina wizyty</label>
                <select name="time" id="time"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 overflow-y-auto" required>
                    required>
                    @forelse($availableSlots as $slot)
                        <option value="{{ $slot }}">{{ $slot }}</option>
                    @empty
                        <option disabled>Brak wolnych terminów dziś</option>
                    @endforelse
                </select>
            </div>

            <div>
                <label for="visit_type" class="block font-medium text-gray-700">Typ wizyty</label>
                <select id="visit_type" name="visit_type" required
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    <option value="implantology">Implantologia</option>
                    <option value="cavity_treatment">Leczenie pruchnicy</option>
                    <option value="orthodontics">Ortodoncja</option>
                    <option value="root_canal">Leczenie kanałowe</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-[#3E92CC] text-white py-2 px-4 rounded-md hover:bg-[#327db4]">
                Zarezerwuj wizytę
            </button>
        </form>
    </div>
@endsection
