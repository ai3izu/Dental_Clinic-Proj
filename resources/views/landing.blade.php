@extends('layouts.app')

@section('title', 'DentMax - Umów wizytę u dentysty online')

@section('content')
    <section id="about" class="py-16 md:py-24 lg:py-32 text-center text-white bg-cover bg-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Umów wizytę u dentysty <span class="text-[#87CEEB]">online</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto">
                    DentMax to nowoczesny system rezerwacji wizyt w Twojej ulubionej klinice stomatologicznej. Szybko,
                    wygodnie i bezpiecznie.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="bg-white text-[#005691] font-semibold px-8 py-4 rounded-lg shadow-lg hover:bg-gray-50 transition duration-300 transform hover:scale-105">
                        Załóż konto
                    </a>
                    <a href="#doctors"
                        class="bg-transparent border-2 border-white text-white font-semibold px-8 py-4 rounded-lg hover:bg-white hover:text-[#005691] transition duration-300">
                        Nasi specjaliści
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0A1C2B] mb-4">Jak to działa?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Prosty proces rezerwacji wizyty w 3 krokach
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div
                        class="bg-[#005691] text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mb-6 mx-auto">
                        1</div>
                    <h3 class="font-semibold text-xl mb-3 text-center text-[#0A1C2B]">Załóż konto</h3>
                    <p class="text-gray-600">
                        Rejestracja zajmuje tylko 2 minuty. Podaj podstawowe dane i załóż swoje konto pacjenta.
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div
                        class="bg-[#005691] text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mb-6 mx-auto">
                        2</div>
                    <h3 class="font-semibold text-xl mb-3 text-center text-[#0A1C2B]">Wybierz lekarza i termin</h3>
                    <p class="text-gray-600">
                        Przeglądaj dostępne terminy u naszych specjalistów i zarezerwuj wizytę w dogodnym dla Ciebie czasie.
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div
                        class="bg-[#005691] text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mb-6 mx-auto">
                        3</div>
                    <h3 class="font-semibold text-xl mb-3 text-center text-[#0A1C2B]">Zapłać online</h3>
                    <p class="text-gray-600">
                        Bezpieczna płatność online. Otrzymasz potwierdzenie rezerwacji na maila i w aplikacji.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="doctors" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0A1C2B] mb-4">Nasi specjaliści</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Poznaj nasz zespół doświadczonych stomatologów
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div
                    class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/doctor1.jpg') }}" alt="Dr Jan Kowalski - Stomatolog ogólny, Implantolog"
                        class="w-32 h-32 rounded-full object-cover mx-auto mb-6" loading="lazy">
                    <h3 class="font-semibold text-xl mb-1 text-center text-[#0A1C2B]">Dr Jan Kowalski</h3>
                    <p class="text-gray-500 text-center mb-4">Stomatolog ogólny, Implantolog</p>
                    <p class="text-gray-600 mb-6">
                        Specjalista z 15-letnim doświadczeniem. Absolwent Warszawskiego Uniwersytetu Medycznego.
                    </p>
                    <a href="{{ route('doctors.public') }}"
                        class="block w-full bg-[#005691] hover:bg-[#00335C] text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                        Umów wizytę
                    </a>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/doctor2.jpg') }}" alt="Dr Anna Nowak - Ortodonta"
                        class="w-32 h-32 rounded-full object-cover mx-auto mb-6" loading="lazy">
                    <h3 class="font-semibold text-xl mb-1 text-center text-[#0A1C2B]">Dr Anna Nowak</h3>
                    <p class="text-gray-500 text-center mb-4">Ortodonta</p>
                    <p class="text-gray-600 mb-6">
                        Specjalista ortodonta z 10-letnim doświadczeniem. Ekspert w leczeniu wad zgryzu u dorosłych i
                        dzieci.
                    </p>
                    <a href="{{ route('doctors.public') }}"
                        class="block w-full bg-[#005691] hover:bg-[#00335C] text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                        Umów wizytę
                    </a>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/doctor3.jpg') }}" alt="Dr Agnieszka Rak - Chirurg stomatologiczny"
                        class="w-32 h-32 rounded-full object-cover mx-auto mb-6" loading="lazy">
                    <h3 class="font-semibold text-xl mb-1 text-center text-[#0A1C2B]">Dr Agnieszka Rak</h3>
                    <p class="text-gray-500 text-center mb-4">Chirurg stomatologiczny</p>
                    <p class="text-gray-600 mb-6">
                        Specjalista chirurgii stomatologicznej i szczękowo-twarzowej. Wykonuje skomplikowane zabiegi
                        chirurgiczne.
                    </p>
                    <a href="{{ route('doctors.public') }}"
                        class="block w-full bg-[#005691] hover:bg-[#00335C] text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                        Umów wizytę
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0A1C2B] mb-4">Nasze usługi</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kompleksowa opieka stomatologiczna na najwyższym poziomie
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="bg-[#EAF6FF] w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#005691]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-3 text-center text-[#0A1C2B]">Stomatologia zachowawcza</h3>
                    <p class="text-gray-600 text-center">
                        Leczenie próchnicy, wypełnienia kompozytowe, leczenie kanałowe pod mikroskopem
                    </p>
                    <p class="text-[#005691] font-semibold text-center mt-4">od 150 zł</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="bg-[#EAF6FF] w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#005691]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-3 text-center text-[#0A1C2B]">Ortodoncja</h3>
                    <p class="text-gray-600 text-center">
                        Aparaty stałe i ruchome, nakładki Invisalign, leczenie wad zgryzu u dzieci i dorosłych
                    </p>
                    <p class="text-[#005691] font-semibold text-center mt-4">od 2000 zł</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="bg-[#EAF6FF] w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#005691]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-3 text-center text-[#0A1C2B]">Implanty</h3>
                    <p class="text-gray-600 text-center">
                        Kompleksowa implantologia, odbudowa kości, korony i mosty na implantach
                    </p>
                    <p class="text-[#005691] font-semibold text-center mt-4">od 3000 zł</p>
                </div>
            </div>
        </div>
    </section>

    <section id="reviews" class="py-16 bg-[#005691] text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Opinie naszych pacjentów</h2>
                <p class="text-lg opacity-90 max-w-2xl mx-auto">
                    Poznaj doświadczenia osób, które skorzystały z naszych usług
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white bg-opacity-10 p-8 rounded-xl border border-white border-opacity-20">
                    <div class="flex items-center mb-4">
                        <div class="text-[#FFD700] mr-2" aria-label="5 out of 5 stars">
                            ★ ★ ★ ★ ★
                        </div>
                    </div>
                    <p class="italic mb-6">
                        "Bardzo profesjonalna obsługa i nowoczesny system rezerwacji wizyt. Możliwość zapłaty online to
                        ogromne ułatwienie, w innych klinikach, które odwiedzałem brakowało takiego rozwiązania. Polecam!"
                    </p>
                    <div class="flex items-center">
                        <div
                            class="bg-white text-[#005691] rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg mr-4">
                            MK</div>
                        <div>
                            <h4 class="font-semibold">Marek Kowalski</h4>
                        </div>
                    </div>
                </div>

                <div class="bg-white bg-opacity-10 p-8 rounded-xl border border-white border-opacity-20">
                    <div class="flex items-center mb-4">
                        <div class="text-[#FFD700] mr-2" aria-label="5 out of 5 stars">
                            ★ ★ ★ ★ ★
                        </div>
                    </div>
                    <p class="italic mb-6">
                        "System DentMax jest bardzo intuicyjny. Mogę w bardzo łatwy sposób umówić wizytę u wybranego
                        specjalisty, mogę nawet wybierać takiego, jaki mi odpowiada sugerując się opiniami WOW!!."
                    </p>
                    <div class="flex items-center">
                        <div
                            class="bg-white text-[#005691] rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg mr-4">
                            AN</div>
                        <div>
                            <h4 class="font-semibold">Anna Nowak</h4>
                        </div>
                    </div>
                </div>

                <div class="bg-white bg-opacity-10 p-8 rounded-xl border border-white border-opacity-20">
                    <div class="flex items-center mb-4">
                        <div class="text-[#FFD700] mr-2" aria-label="4 out of 5 stars">
                            ★ ★ ★ ★ ☆
                        </div>
                    </div>
                    <p class="italic mb-6">
                        "DentMax znacznie ułatwia kontakt z kliniką. Wszystkie moje wizyty i opis dokumentacji medycznej są
                        w jednym miejscu. Brakuje tylko aplikacji mobilnej."
                    </p>
                    <div class="flex items-center">
                        <div
                            class="bg-white text-[#005691] rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg mr-4">
                            PW</div>
                        <div>
                            <h4 class="font-semibold">Piotr Wiśniewski</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0A1C2B] mb-4">Najczęściej zadawane pytania</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Odpowiadamy na najpopularniejsze pytania dotyczące naszych usług
                </p>
            </div>

            <div class="max-w-3xl mx-auto">
                <div class="mb-6 border-b border-gray-200 pb-6">
                    <p class="flex justify-between items-center w-full text-left font-semibold text-lg text-[#0A1C2B]">
                        <span>Jak mogę umówić wizytę przez system DentMax?</span>
                    </p>
                    <div class="mt-4 text-gray-600">
                        <p>Aby umówić wizytę, należy założyć konto w systemie DentMax, wybrać lekarza i specjalizację, a
                            następnie dostępny termin z kalendarza. Po wyborze terminu możesz od razu opłacić wizytę online.
                        </p>
                    </div>
                </div>

                <div class="mb-6 border-b border-gray-200 pb-6">
                    <p class="flex justify-between items-center w-full text-left font-semibold text-lg text-[#0A1C2B]">
                        <span>Czy mogę odwołać lub przełożyć wizytę?</span>
                    </p>
                    <div class="mt-4 text-gray-600">
                        <p>Tak, możesz odwołać lub zmienić termin wizyty w swoim panelu pacjenta.</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="flex justify-between items-center w-full text-left font-semibold text-lg text-[#0A1C2B]">
                        <span>Czy mogę zobaczyć historię moich wizyt?</span>
                    </p>
                    <div class="mt-4 text-gray-600">
                        <p>Tak, po zalogowaniu się na swoje konto masz dostęp do pełnej historii wizyt wraz z opisami
                            zabiegów, zaleceniami lekarskimi i dokumentacją medyczną.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection