@extends('layouts.app')

@section('title', 'dr ' . $doctor->user->first_name . ' ' . $doctor->user->last_name . ' - DentMax')

@section('content')
    <div class="container mx-auto px-4 py-12">
        {{-- powrot --}}
        <div class="mb-6">
            <a href="{{ route('doctors.public') }}"
                class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Wróć do listy lekarzy
            </a>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md mb-8">
            <div class="flex flex-col items-center md:flex-row md:items-start md:space-x-8">
                <div class="mb-6 md:mb-0">
                    @if ($doctor->photo_url)
                        <img src="{{ asset($doctor->photo_url) }}" alt="{{ $doctor->photo_alt }}"
                            class="w-48 h-48 rounded-full object-cover shadow-lg border-4 border-blue-200">
                    @else
                        <div
                            class="w-48 h-48 rounded-full bg-gray-200 flex items-center justify-center shadow-lg border-4 border-blue-200">
                            <span
                                class="text-6xl text-gray-600">{{ strtoupper(substr($doctor->user->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->user->last_name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">dr {{ $doctor->user->first_name }}
                        {{ $doctor->user->last_name }}</h1>
                    <p class="text-blue-600 text-xl font-semibold mb-4">{{ $doctor->specialization }}</p>
                    <p class="text-gray-800 text-lg leading-relaxed mb-6">{{ $doctor->description }}</p>

                    {{-- informacje konaktowe --}}
                    <div class="mb-6 text-gray-700">
                        <p class="flex items-center justify-center md:justify-start mb-2">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <a href="mailto:{{ $doctor->user->email }}" class="hover:underline">{{ $doctor->user->email }}</a>
                        </p>
                        <p class="flex items-center justify-center md:justify-start">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <a href="tel:{{ $doctor->phone_number }}" class="hover:underline">{{ $doctor->phone_number }}</a>
                        </p>
                    </div>

                    <div class="mt-6">
                        @auth
                            @if (Auth::user()->role === 'patient')
                                <a href="{{ route('patient.appoitment.create', $doctor->id) }}"
                                    class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                    Umów wizytę z dr {{ $doctor->user->last_name }}
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                    Zaloguj się aby umówić wizytę
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                Zaloguj się aby umówić wizytę
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Opinie o dr {{ $doctor->user->last_name }}</h2>

            {{-- wiadomosci dla sesji --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukces!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Błąd!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- dodawanie opini --}}
            @auth
                @if (Auth::user()->role === 'patient' && $canAddReview)
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Dodaj swoją opinię</h3>
                        <form action="{{ route('doctors.reviews.store', $doctor->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Twoja opinia:</label>
                                <textarea name="content" id="content" rows="4"
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @if($errors->has('content')) border-red-500 @endif"
                                    placeholder="Napisz swoją opinię o tym lekarzu..."></textarea>
                                @if($errors->has('content'))
                                    <p class="text-red-500 text-xs italic mt-2">{{ $errors->first('content') }}</p>
                                @endif
                            </div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 focus:outline-none focus:shadow-outline">
                                Dodaj opinię
                            </button>
                        </form>
                    </div>
                @elseif (Auth::user()->role === 'patient')
                    <p class="text-gray-700 text-lg mb-8">
                        Aby dodać opinię, musisz mieć ukończoną wizytę u tego lekarza i jeszcze nie dodać opinii.
                    </p>
                @endif
            @else
                <p class="text-gray-700 text-lg mb-8">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Zaloguj się</a> jako pacjent, aby móc dodawać opinie po odbyciu wizyty.
                </p>
            @endauth


            @if ($doctor->reviews->isEmpty())
                <p class="text-gray-700 text-lg">Brak opinii dla tego lekarza. Bądź pierwszym, który wystawi opinię!</p>
            @else
                <div class="space-y-6">
                    @foreach ($doctor->reviews as $review)
                        <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                            <div class="flex items-center mb-2">
                                @if ($review->patient->user->photo_url ?? false)
                                    <img src="{{ asset($review->patient->user->photo_url) }}"
                                        alt="{{ $review->patient->user->first_name }} {{ $review->patient->user->last_name }}"
                                        class="w-10 h-10 rounded-full object-cover mr-3">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                        <span
                                            class="text-md text-gray-600">{{ strtoupper(substr($review->patient->user->first_name, 0, 1)) }}{{ strtoupper(substr($review->patient->user->last_name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <p class="font-semibold text-gray-900">{{ $review->patient->user->first_name }}
                                    {{ $review->patient->user->last_name }}</p>
                            </div>
                            <p class="text-gray-700 italic">"{{ $review->content }}"</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
