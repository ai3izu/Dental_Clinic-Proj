<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uzupełnij profil - DentMax</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-b from-[#3E92CC] to-[#62B6CB] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-6 sm:p-8 md:p-10 rounded-lg shadow-lg w-full max-w-sm sm:max-w-md">
        <h2 class="text-2xl sm:text-3xl font-semibold text-[#13293D] mb-4 sm:mb-6">Uzupełnij dane profilu</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 sm:mb-6">
                <strong>Błąd:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm sm:text-base">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('patient.complete-profile.update') }}">
            @csrf

            <div class="mb-3 sm:mb-4">
                <label for="phone_number" class="block text-sm sm:text-base text-[#13293D] font-medium">Numer
                    telefonu:</label>
                <input type="text" name="phone_number" id="phone_number"
                    value="{{ old('phone_number', optional($patient)->phone_number) }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-3 sm:mb-4">
                <label for="postal_code" class="block text-sm sm:text-base text-[#13293D] font-medium">Kod
                    pocztowy:</label>
                <input type="text" name="postal_code" id="postal_code"
                    value="{{ old('postal_code', optional($patient)->postal_code) }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-3 sm:mb-4">
                <label for="city" class="block text-sm sm:text-base text-[#13293D] font-medium">Miasto:</label>
                <input type="text" name="city" id="city" value="{{ old('city', optional($patient)->city) }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-3 sm:mb-4">
                <label for="street" class="block text-sm sm:text-base text-[#13293D] font-medium">Ulica:</label>
                <input type="text" name="street" id="street" value="{{ old('street', optional($patient)->street) }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-3 sm:mb-4">
                <label for="apartment_number" class="block text-sm sm:text-base text-[#13293D] font-medium">Numer
                    mieszkania (opcjonalnie):</label>
                <input type="text" name="apartment_number" id="apartment_number"
                    value="{{ old('apartment_number', optional($patient)->apartment_number) }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base">
            </div>

            <div class="mb-3 sm:mb-4">
                <label for="staircase_number" class="block text-sm sm:text-base text-[#13293D] font-medium">Numer klatki
                    (opcjonalnie):</label>
                <input type="text" name="staircase_number" id="staircase_number"
                    value="{{ old('staircase_number', optional($patient)->staircase_number) }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base">
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="birth_date" class="block text-sm sm:text-base text-[#13293D] font-medium">Data
                    urodzenia:</label>
                <input type="date" name="birth_date" id="birth_date"
                    value="{{ old('birth_date', optional($patient)->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->format('Y-m-d') : '') }}"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required min="1913-01-01" max="2008-12-31">
            </div>

            <button type="submit"
                class="w-full bg-[#13293D] text-white p-2 sm:p-3 rounded-lg font-semibold hover:bg-[#16324F] transition duration-300 text-sm sm:text-base mb-3 sm:mb-4">
                Zapisz dane
            </button>

            <div class="text-center">
                <a href="{{ route('patient.dashboard') }}"
                    class="text-[#5FA8D3] text-sm sm:text-base font-medium transition duration-300">
                    Lub zrób to później i przejdź do profilu
                </a>
            </div>
        </form>
    </div>
</body>

</html>