@extends('layouts.app')

@section('content')
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($patient) ? 'Edytuj dane pacjenta' : 'Dodaj nowego pacjenta' }}
        </h2>

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

        <form method="POST"
            action="{{ isset($patient) ? route('admin.patients.update', $patient->id) : route('admin.patients.store') }}"
            class="space-y-5">

            @csrf
            @if (isset($patient))
                @method('PUT')
            @endif

            {{-- Imię --}}
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">Imię</label>
                <input type="text" name="first_name" id="first_name" placeholder="np. Jan"
                    value="{{ old('first_name', $patient->user->first_name ?? '') }}" required
                    class="border p-2 rounded w-full mt-1 @error('first_name') border-red-500 @enderror"
                    aria-describedby="first_name-error" @error('first_name') aria-invalid="true" @enderror
                    **aria-label="Imię pacjenta" **>
                @error('first_name')
                    <span class="text-red-700 text-sm" id="first_name-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nazwisko --}}
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Nazwisko</label>
                <input type="text" name="last_name" id="last_name" placeholder="np. Kowlaski"
                    value="{{ old('last_name', $patient->user->last_name ?? '') }}" required
                    class="border p-2 rounded w-full mt-1 @error('last_name') border-red-500 @enderror"
                    aria-describedby="last_name-error" @error('last_name') aria-invalid="true" @enderror
                    **aria-label="Nazwisko pacjenta" **>
                @error('last_name')
                    <span class="text-red-700 text-sm" id="last_name-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="email@example.pl"
                    value="{{ old('email', $patient->user->email ?? '') }}" required
                    class="border p-2 rounded w-full mt-1 @error('email') border-red-500 @enderror"
                    aria-describedby="email-error" @error('email') aria-invalid="true" @enderror
                    **aria-label="Adres e-mail pacjenta" **>
                @error('email')
                    <span class="text-red-700 text-sm" id="email-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Numer telefonu --}}
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Numer telefonu</label>
                <input type="tel" name="phone_number" id="phone_number" placeholder="000-000-000"
                    value="{{ old('phone_number', $patient->phone_number ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('phone_number') border-red-500 @enderror"
                    aria-describedby="phone_number-error" @error('phone_number') aria-invalid="true" @enderror
                    **aria-label="Numer telefonu pacjenta" **>
                @error('phone_number')
                    <span class="text-red-700 text-sm" id="phone_number-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Data urodzenia --}}
            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700">Data urodzenia</label>
                <input type="date" name="birth_date" id="birth_date"
                    value="{{ old('birth_date', $patient->birth_date ?? '') }}" max="2015-12-31"
                    class="border p-2 rounded w-full mt-1 @error('birth_date') border-red-500 @enderror"
                    aria-describedby="birth_date-error" @error('birth_date') aria-invalid="true" @enderror
                    **aria-label="Data urodzenia pacjenta" **>
                @error('birth_date')
                    <span class="text-red-700 text-sm" id="birth_date-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kod pocztowy --}}
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Kod pocztowy</label>
                <input type="text" name="postal_code" id="postal_code" placeholder="00-000"
                    value="{{ old('postal_code', $patient->postal_code ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('postal_code') border-red-500 @enderror"
                    aria-describedby="postal_code-error" @error('postal_code') aria-invalid="true" @enderror
                    **aria-label="Kod pocztowy" **>
                @error('postal_code')
                    <span class="text-red-700 text-sm" id="postal_code-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Miasto --}}
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Miasto</label>
                <input type="text" name="city" id="city" placeholder="np. Warszawa"
                    value="{{ old('city', $patient->city ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('city') border-red-500 @enderror"
                    aria-describedby="city-error" @error('city') aria-invalid="true" @enderror
                    **aria-label="Miasto zamieszkania" **>
                @error('city')
                    <span class="text-red-700 text-sm" id="city-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Ulica --}}
            <div>
                <label for="street" class="block text-sm font-medium text-gray-700">Ulica</label>
                <input type="text" name="street" id="street" placeholder="np. Sympatyczna"
                    value="{{ old('street', $patient->street ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('street') border-red-500 @enderror"
                    aria-describedby="street-error" @error('street') aria-invalid="true" @enderror
                    **aria-label="Ulica zamieszkania" **>
                @error('street')
                    <span class="text-red-700 text-sm" id="street-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Numer mieszkania --}}
            <div>
                <label for="apartment_number" class="block text-sm font-medium text-gray-700">Numer budynku /
                    mieszkania</label>
                <input type="text" name="apartment_number" id="apartment_number" placeholder="np. 333"
                    value="{{ old('apartment_number', $patient->apartment_number ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('apartment_number') border-red-500 @enderror"
                    aria-describedby="apartment_number-error" @error('apartment_number') aria-invalid="true" @enderror
                    **aria-label="Numer budynku lub mieszkania" **>
                @error('apartment_number')
                    <span class="text-red-700 text-sm" id="apartment_number-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Numer klatki (opcjonalne) --}}
            <div>
                <label for="staircase_number" class="block text-sm font-medium text-gray-700">Numer klatki
                    (opcjonalnie)</label>
                <input type="text" name="staircase_number" id="staircase_number" placeholder="np 1/33"
                    value="{{ old('staircase_number', $patient->staircase_number ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('staircase_number') border-red-500 @enderror"
                    aria-describedby="staircase_number-error" @error('staircase_number') aria-invalid="true" @enderror
                    **aria-label="Numer klatki (opcjonalne)" **>
                @error('staircase_number')
                    <span class="text-red-700 text-sm" id="staircase_number-error" role="alert">{{ $message }}</span>
                @enderror
            </div>


            <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#236DAA] hover:bg-[#1E5A90] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
                    {{ isset($patient) ? 'Zapisz zmiany' : 'Dodaj pacjenta' }}
                </button>

                <a href="{{ route('admin.dashboard', ['tab' => 'patients']) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-[#13293D] font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base text-center">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
@endsection