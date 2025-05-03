<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - DentMax</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-b from-[#3E92CC] to-[#62B6CB] h-screen flex items-center justify-center flex-col">

    <div class="bg-white p-6 sm:p-8 md:p-10 rounded-lg shadow-lg w-full max-w-sm sm:max-w-md">
        <h2 class="text-2xl sm:text-3xl font-semibold text-[#13293D] mb-4 sm:mb-6">Zarejestruj się</h2>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2 sm:mb-4">
            <strong>Błąd:</strong>
            <ul>
                @foreach($errors->all() as $err)
                <li class="text-sm sm:text-base">{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-2 sm:mb-4">
                <label for="first_name" class="block text-sm sm:text-base text-[#13293D] font-medium">Imię:</label>
                <input type="text" name="first_name" id="first_name"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-2 sm:mb-4">
                <label for="last_name" class="block text-sm sm:text-base text-[#13293D] font-medium">Nazwisko:</label>
                <input type="text" name="last_name" id="last_name"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-2 sm:mb-4">
                <label for="email" class="block text-sm sm:text-base text-[#13293D] font-medium">Email:</label>
                <input type="email" name="email" id="email"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-2 sm:mb-4">
                <label for="password" class="block text-sm sm:text-base text-[#13293D] font-medium">Hasło:</label>
                <input type="password" name="password" id="password"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="password_confirmation" class="block text-sm sm:text-base text-[#13293D] font-medium">Potwierdź hasło:</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full p-2 sm:p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3] text-sm sm:text-base"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-[#13293D] text-white p-2 sm:p-3 rounded-lg font-semibold hover:bg-[#16324F] transition duration-300 text-sm sm:text-base">Zarejestruj
                się</button>
        </form>

        <p class="mt-2 sm:mt-4 text-center text-sm sm:text-base">
            Masz już konto? <a href="{{ route('login') }}" class="text-[#5FA8D3] hover:underline">Zaloguj się</a>
        </p>
    </div>

</body>

</html>