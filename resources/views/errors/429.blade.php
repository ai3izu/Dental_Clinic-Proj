<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zbyt wiele żądań</title>
    @vite('resources/css/app.css')
</head>

<body
    class="font-inter bg-gradient-to-b from-[#3E92CC] to-[#62B6CB] text-gray-800 flex items-center justify-center min-h-screen m-0 p-4">
    <div class="bg-white text-center p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-sm sm:max-w-md">
        <h1 class="text-xl sm:text-3xl mb-4 sm:mb-6 text-[#13293D] font-semibold">🛑 Zbyt wiele żądań</h1>
        <p class="text-base sm:text-xl mb-6 sm:mb-8">Wykonałeś zbyt wiele żądań w krótkim czasie. Proszę spróbuj
            ponownie za chwilę.</p>
        <a href="{{ url()->previous() }}"
            class="inline-block px-5 py-3 sm:px-8 sm:py-4 bg-[#13293D] text-white rounded-lg no-underline transition duration-200 hover:bg-[#16324F] text-base sm:text-xl">
            Wróć
        </a>
    </div>
</body>

</html>
