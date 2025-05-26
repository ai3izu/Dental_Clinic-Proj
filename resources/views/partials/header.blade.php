<nav x-data="{ open: false }" class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3 md:py-4">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 lg:h-8 lg:w-8 text-[#005691]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-[#005691] text-xl lg:text-2xl font-bold">
                    <a href="{{ route('landing') }}">DentMax @auth {{ Auth::user()->role }} @endauth
                    </a>
                </span>
            </div>

            <div class="hidden lg:flex justify-center flex-1 items-center space-x-6">
                <a href="{{ route('landing') }}#doctors"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">Lekarze</a>
                <a href="{{ route('landing') }}#services"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">Usługi</a>
                <a href="{{ route('landing') }}#reviews"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">Opinie</a>
                <a href="{{ route('landing') }}#faq"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">FAQ</a>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">Panel admina</a>
                    @elseif(Auth::user()->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}"
                            class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">Panel lekarza</a>
                    @elseif(Auth::user()->role === 'patient')
                        <a href="{{ route('patient.dashboard') }}"
                            class="text-[#0A1C2B] hover:text-[#005691] transition text-sm lg:text-base">Mój profil</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-[#005691] hover:bg-[#00335C] text-white font-semibold px-4 py-2 lg:px-5 lg:py-2 rounded-lg shadow-md transition duration-300 text-sm lg:text-base">
                            Wyloguj
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-[#005691] hover:bg-[#00335C] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 text-sm lg:text-base">Logowanie</a>
                    <a href="{{ route('register') }}"
                        class="bg-white border border-[#005691] text-[#005691] font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-gray-50 transition duration-300 text-sm lg:text-base">Rejestracja</a>
                @endauth
            </div>

            <div class="lg:hidden flex items-center">
                <button @click="open = !open" class="text-[#0A1C2B] focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" @click.outside="open = false" x-transition.duration.200ms class="lg:hidden pb-3">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('landing') }}#doctors"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">Lekarze</a>
                <a href="{{ route('landing') }}#services"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">Usługi</a>
                <a href="{{ route('landing') }}#reviews"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">Opinie</a>
                <a href="{{ route('landing') }}#faq"
                    class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">FAQ</a>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">Panel admina</a>
                    @elseif(Auth::user()->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}"
                            class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">Panel lekarza</a>
                    @elseif(Auth::user()->role === 'patient')
                        <a href="{{ route('patient.dashboard') }}"
                            class="text-[#0A1C2B] hover:text-[#005691] transition text-sm">Mój profil</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit"
                            class="w-full bg-[#005691] hover:bg-[#00335C] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 text-sm">
                            Wyloguj się
                        </button>
                    </form>
                @else
                    <div class="flex flex-col space-y-2 pt-2">
                        <a href="{{ route('login') }}"
                            class="w-full bg-[#005691] hover:bg-[#00335C] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 text-sm text-center">
                            Zaloguj się
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full bg-white border border-[#005691] text-[#005691] font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-gray-50 transition duration-300 text-sm text-center">
                            Rejestracja
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
