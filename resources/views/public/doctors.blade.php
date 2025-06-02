@extends('layouts.app')

@section('title', 'Nasi specjaliści - DentMax')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Nasi specjaliści</h1>
            <p class="text-lg text-white max-w-2xl mx-auto">
                Poznaj nasz zespół doświadczonych stomatologów
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($doctors as $doctor)
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="flex flex-col items-center">
                        @if ($doctor->photo_url)
                            @php
                                $imageUrl = $doctor->photo_url;
                                if (!Str::startsWith($imageUrl, 'storage/')) {
                                    $imageUrl = 'storage/' . $imageUrl;
                                }
                            @endphp
                            <img src="{{ asset($imageUrl) }}" alt="{{ $doctor->photo_alt }}"
                                class="w-32 h-32 rounded-full object-cover mb-4">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                                <span
                                    class="text-4xl text-gray-600">{{ strtoupper(substr($doctor->user->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->user->last_name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-900">dr {{ $doctor->user->first_name }}
                            {{ $doctor->user->last_name }}
                        </h3>
                        <p class="text-gray-700 mb-4">{{ $doctor->specialization }}</p>
                        <p class="text-gray-800 text-center mb-6">{{ $doctor->description }}</p>

                        <div class="flex justify-center">

                            <a href="{{ route('doctors.show', $doctor->id) }}"
                                class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-300">
                                Umów wizytę
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-10">
            {{-- Pamiętaj, aby $doctors w kontrolerze był instancją paginatora, np. ->paginate(10) --}}
            {{-- Jeśli $doctors jest kolekcją (->get()), ten link nie zadziała --}}
            {{ $doctors->links() }}
        </div>
    </div>
@endsection
