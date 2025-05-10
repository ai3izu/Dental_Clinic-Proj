@extends('layouts.app')

@section('content')
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($patient) ? 'Edytuj pacjenta' : 'Dodaj nowego pacjenta' }}
        </h2>

        <form method="POST"
            action="{{ isset($patient) ? route('admin.patients.update', $patient->id) : route('admin.patients.store') }}"
            class="space-y-4">

            @csrf
            @if(isset($patient))
                @method('PUT')
            @endif

            <input type="text" name="first_name" placeholder="Imię"
                value="{{ old('first_name', $patient->user->first_name ?? '') }}" required
                class="border p-2 rounded w-full">

            <input type="text" name="last_name" placeholder="Nazwisko"
                value="{{ old('last_name', $patient->user->last_name ?? '') }}" required class="border p-2 rounded w-full">

            <input type="email" name="email" placeholder="Email" value="{{ old('email', $patient->user->email ?? '') }}"
                class="border p-2 rounded w-full">

            <input type="text" name="phone_number" placeholder="Numer telefonu"
                value="{{ old('phone_number', $patient->phone_number ?? '') }}" class="border p-2 rounded w-full">

            <input type="text" name="postal_code" placeholder="Kod pocztowy"
                value="{{ old('postal_code', $patient->postal_code ?? '') }}" class="border p-2 rounded w-full">

            <input type="text" name="city" placeholder="Miasto" value="{{ old('city', $patient->city ?? '') }}"
                class="border p-2 rounded w-full">

            <input type="text" name="street" placeholder="Ulica" value="{{ old('street', $patient->street ?? '') }}"
                class="border p-2 rounded w-full">

            <input type="text" type="text" name="apartment_number" placeholder="Numer mieszkania"
                value="{{ old('apartment_number', $patient->apartment_number ?? '') }}" class="border p-2 rounded w-full">

            <input type="text" name="staircase_number" placeholder="Numer klatki"
                value="{{ old('staircase_number', $patient->staircase_number ?? '') }}" class="border p-2 rounded w-full">

            <input type="date" name="birth_date" value="{{ old('birth_date', $patient->birth_date ?? '') }}"
                class="border p-2 rounded w-full">

            <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#3E92CC] hover:bg-[#2f6ea3] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
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