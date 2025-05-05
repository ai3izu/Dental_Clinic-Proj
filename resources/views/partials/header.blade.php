@auth
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3 md:py-4">
                <!-- Logo and name - always visible -->
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 md:h-8 md:w-8 text-primary" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="text-primary text-xl md:text-2xl font-bold">DentMax {{ Auth::user()->role }}</span>
                </div>

                <!-- Login buttons - visible only on desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('landing') }}"
                        class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Strona główna</a>
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Panel admina</a>
                    @elseif(Auth::user()->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}"
                            class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Panel lekarza</a>
                    @elseif(Auth::user()->role === 'patient')
                        <a href="{{ route('patient.dashboard') }}"
                            class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Mój profil</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-primary hover:bg-primaryDark text-white font-semibold px-4 py-2 lg:px-5 lg:py-2 rounded-lg shadow-md transition duration-300 text-sm lg:text-base">
                            Wyloguj
                        </button>
                    </form>
                </div>

                <!-- Button for hamburger menu - visible only on mobile -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-primaryDark focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu for mobile, by default hidden, visible only on mobile -->
            <div id="mobile-menu" class="hidden md:hidden pb-3">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('landing') }}" class="text-primaryDark hover:text-primary transition text-sm">Strona
                        główna</a>
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-primaryDark hover:text-primary transition text-sm">Panel admina</a>
                    @elseif(Auth::user()->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}"
                            class="text-primaryDark hover:text-primary transition text-sm">Panel lekarza</a>
                    @elseif(Auth::user()->role === 'patient')
                        <a href="{{ route('patient.dashboard') }}"
                            class="text-primaryDark hover:text-primary transition text-sm">Mój profil</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-primary hover:bg-primaryDark text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 text-sm">
                            Wyloguj się
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@else
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3 md:py-4">
                <!-- Logo and name - always visible -->
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 md:h-8 md:w-8 text-primary" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="text-primary text-xl md:text-2xl font-bold">DentMax</span>
                </div>

                <!-- Main menu - visible only on desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#doctors"
                        class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Lekarze</a>
                    <a href="#services"
                        class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Usługi</a>
                    <a href="#reviews"
                        class="text-primaryDark hover:text-primary transition text-sm lg:text-base">Opinie</a>
                    <a href="#faq" class="text-primaryDark hover:text-primary transition text-sm lg:text-base">FAQ</a>
                </div>

                <!-- Login buttons - visible only on desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="bg-primary hover:bg-primaryDark text-white font-semibold px-4 py-2 lg:px-5 lg:py-2 rounded-lg shadow-md transition duration-300 text-sm lg:text-base">
                        Logowanie
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-white border border-primary text-primary font-semibold px-4 py-2 lg:px-5 lg:py-2 rounded-lg shadow-md hover:bg-gray-50 transition duration-300 text-sm lg:text-base">
                        Rejestracja
                    </a>
                </div>

                <!-- Hamburger menu button, by default visible on mobile -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-primaryDark focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu for mobile, by default hidden, visible only on mobile -->
            <div id="mobile-menu" class="hidden md:hidden pb-3">
                <div class="flex flex-col space-y-3">
                    <a href="#doctors" class="text-primaryDark hover:text-primary transition text-sm">Nasi lekarze</a>
                    <a href="#services" class="text-primaryDark hover:text-primary transition text-sm">Usługi</a>
                    <a href="#reviews" class="text-primaryDark hover:text-primary transition text-sm">Opinie</a>
                    <a href="#faq" class="text-primaryDark hover:text-primary transition text-sm">FAQ</a>

                    <div class="flex flex-col space-y-2 pt-2">
                        <a href="{{ route('login') }}"
                            class="w-full bg-primary hover:bg-primaryDark text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 text-sm text-center">
                            Zaloguj się
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full bg-white border border-primary text-primary font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-gray-50 transition duration-300 text-sm text-center">
                            Rejestracja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endauth
<!-- Script for mobile menu toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
