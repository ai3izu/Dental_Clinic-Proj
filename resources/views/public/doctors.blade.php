@extends('layouts.app')

@section('title', 'Nasi specjaliści - DentMax')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Nasi specjaliści</h1>
            <p class="text-lg text-accent max-w-2xl mx-auto">
                Poznaj nasz zespół doświadczonych stomatologów
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($doctors as $doctor)
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="flex flex-col items-center">
                        @if ($doctor->photo_url)
                            <img src="{{ asset($doctor->photo_url) }}" alt="{{ $doctor->photo_alt }}"
                                class="w-32 h-32 rounded-full object-cover mb-4">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                                <span
                                    class="text-4xl text-gray-400">{{ strtoupper(substr($doctor->user->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->user->last_name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <h3 class="text-xl font-semibold text-primaryDark">dr {{ $doctor->user->first_name }}
                            {{ $doctor->user->last_name }}</h3>
                        <p class="text-gray-500 mb-4">{{ $doctor->specialization }}</p>
                        <p class="text-gray-600 text-center mb-6">{{ $doctor->description }}</p>

                        <div class="flex justify-center">
                            @auth
                                @if (Auth::user()->role === 'patient')
                                    <a href="{{ route('patient.appoitment.create', $doctor->id) }}"
                                        class="w-full bg-primary hover:bg-primaryDark text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                                        Umów wizytę
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full bg-primary hover:bg-primaryDark text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                                        Umów wizytę
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="w-full bg-primary hover:bg-primaryDark text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                                    Umów wizytę
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-10">
            {{ $doctors->links() }}
        </div>
    </div>
@endsection
