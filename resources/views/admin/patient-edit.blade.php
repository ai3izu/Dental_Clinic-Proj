@extends('layouts.app')

@section('content')
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">Edytuj pacjenta</h2>

        <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" class="space-y-3 sm:space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="first_name" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Imię</label>
                <input type="text" id="first_name" name="first_name"
                    value="{{ old('first_name', $patient->user->first_name) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="last_name" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Nazwisko</label>
                <input type="text" id="last_name" name="last_name"
                    value="{{ old('last_name', $patient->user->last_name) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="email" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $patient->user->email) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="postal_code" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Kod
                    pocztowy</label>
                <input type="text" id="postal_code" name="postal_code"
                    value="{{ old('postal_code', $patient->postal_code) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="city" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Miasto</label>
                <input type="text" id="city" name="city" value="{{ old('city', $patient->city) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="street" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Ulica</label>
                <input type="text" id="street" name="street" value="{{ old('street', $patient->street) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="apartment_number" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Numer
                    mieszkania</label>
                <input type="text" id="apartment_number" name="apartment_number"
                    value="{{ old('apartment_number', $patient->apartment_number) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="staircase_number" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Numer
                    klatki</label>
                <input type="text" id="staircase_number" name="staircase_number"
                    value="{{ old('staircase_number', $patient->staircase_number) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div>
                <label for="birth_date" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Data
                    urodzenia</label>
                <input type="date" id="birth_date" name="birth_date"
                    value="{{ old('birth_date', $patient->birth_date) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>


            <div>
                <label for="phone_number" class="block text-sm sm:text-base font-semibold text-[#13293D] mb-1">Numer
                    telefonu</label>
                <input type="text" id="phone_number" name="phone_number"
                    value="{{ old('phone_number', $patient->phone_number) }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#3E92CC] focus:outline-none text-sm sm:text-base">
            </div>

            <div class="pt-3 sm:pt-4 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#3E92CC] hover:bg-[#2f6ea3] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
                    Zapisz zmiany
                </button>

                <a href="{{ route('admin.dashboard', ['tab' => 'patients']) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-[#13293D] font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base text-center">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
@endsection
