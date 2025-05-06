<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="text-xl font-bold">DentMax</span>
                </div>
                <p class="text-gray-400">
                    Nowoczesna klinika stomatologiczna z kompleksową ofertą usług dentystycznych i wygodnym systemem
                    rezerwacji online.
                </p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Dla pacjentów</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('register') }}"
                            class="text-gray-400 hover:text-white transition">Rejestracja</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Logowanie</a>
                    </li>
                    <li><a href="{{ route('landing') }}#doctors" class="text-gray-400 hover:text-white transition">Nasi
                            lekarze</a></li>
                    <li><a href="{{ route('landing') }}#services"
                            class="text-gray-400 hover:text-white transition">Cennik</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Informacje</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('landing') }}#about" class="text-gray-400 hover:text-white transition">O
                            klinice</a></li>
                    <li><a href="{{ route('landing') }}#reviews"
                            class="text-gray-400 hover:text-white transition">Opinie</a></li>
                    <li><a href="{{ route('landing') }}#faq" class="text-gray-400 hover:text-white transition">FAQ</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Dla lekarzy</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Panel
                            lekarza</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 mb-4 md:mb-0">
                &copy; {{ date('Y') }} Klinika Stomatologiczna DentMax. Wszystkie prawa zastrzeżone.
            </p>

        </div>
    </div>
</footer>
