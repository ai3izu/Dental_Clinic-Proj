@extends('layouts.app')

@section('title', 'Nasi Lekarze')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold text-primaryDark mb-6 text-center">Nasi Lekarze</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($doctors as $doctor)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ $doctor['photo_url'] ?? asset('images/default-doctor.jpg') }}"
                        alt="{{ $doctor['first_name'] }} {{ $doctor['last_name'] }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="font-semibold text-xl mb-2 text-primaryDark">{{ $doctor['first_name'] }}
                            {{ $doctor['last_name'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $doctor['specialization'] }}</p>
                        <p class="text-gray-700">{{ Str::limit($doctor['description'], 100) }}</p>
                        <div class="mt-4">
                            @auth
                                <a href="{{ route('patient.appointment.create', ['doctor_id' => $doctor['id']]) }}"
                                    class="inline-block bg-primary hover:bg-primaryDark text-white font-semibold py-2 px-4 rounded-full transition duration-300">
                                    Umów wizytę
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block bg-primary hover:bg-primaryDark text-white font-semibold py-2 px-4 rounded-full transition duration-300">
                                    Umów wizytę (Zaloguj się)
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
