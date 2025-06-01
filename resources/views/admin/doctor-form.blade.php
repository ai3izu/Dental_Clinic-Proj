@extends('layouts.app')

@section('content')
    {{-- container na wszystko --}}
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($doctor) ? 'Edytuj dane dentysty' : 'Dodaj nowego dentystę' }}
        </h2>
        {{-- komunikaty o błedach --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Wystąpiły błędy!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- caly formularz --}}
        <form method="POST"
            action="{{ isset($doctor) ? route('admin.doctors.update', $doctor->id) : route('admin.doctors.store') }}"
            class="space-y-5" enctype="multipart/form-data">
            @csrf
            @if (isset($doctor))
                @method('PUT')
            @endif

            {{-- Imię --}}
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">Imię</label>
                <input type="text" name="first_name" id="first_name" placeholder="np. Jan"
                    value="{{ old('first_name', $doctor->user->first_name ?? '') }}" required
                    class="border p-2 rounded w-full mt-1 @error('first_name') border-red-500 @enderror"
                    aria-describedby="first_name-error" @error('first_name') aria-invalid="true" @enderror
                    **aria-label="Imię dentysty" **>
                @error('first_name')
                    <span class="text-red-700 text-sm" id="first_name-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nazwisko --}}
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Nazwisko</label>
                <input type="text" name="last_name" id="last_name" placeholder="np. Kowlaski"
                    value="{{ old('last_name', $doctor->user->last_name ?? '') }}" required
                    class="border p-2 rounded w-full mt-1 @error('last_name') border-red-500 @enderror"
                    aria-describedby="last_name-error" @error('last_name') aria-invalid="true" @enderror
                    **aria-label="Nazwisko dentysty" **>
                @error('last_name')
                    <span class="text-red-700 text-sm" id="last_name-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="email@example.pl"
                    value="{{ old('email', $doctor->user->email ?? '') }}" required
                    class="border p-2 rounded w-full mt-1 @error('email') border-red-500 @enderror"
                    aria-describedby="email-error" @error('email') aria-invalid="true" @enderror
                    **aria-label="Adres e-mail dentysty" **>
                @error('email')
                    <span class="text-red-700 text-sm" id="email-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Numer telefonu --}}
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Numer telefonu</label>
                <input type="tel" name="phone_number" id="phone_number" placeholder="000-000-000"
                    value="{{ old('phone_number', $doctor->phone_number ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('phone_number') border-red-500 @enderror"
                    aria-describedby="phone_number-error" @error('phone_number') aria-invalid="true" @enderror
                    **aria-label="Numer telefonu dentysty" **>
                @error('phone_number')
                    <span class="text-red-700 text-sm" id="phone_number-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Specjalizacja --}}
            <div>
                <label for="specialization" class="block text-sm font-medium text-gray-700">Specjalizacja</label>
                <input type="text" name="specialization" id="specialization" placeholder="np. Ortodonta"
                    value="{{ old('specialization', $doctor->specialization ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('specialization') border-red-500 @enderror"
                    aria-describedby="specialization-error" @error('specialization') aria-invalid="true" @enderror
                    **aria-label="Specjalizacja dentysty" **>
                @error('specialization')
                    <span class="text-red-700 text-sm" id="specialization-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- URL zdjęcia --}}
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Zdjęcie</label>
                <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg,image/gif"
                    class="border p-2 rounded w-full mt-1 @error('photo') border-red-500 @enderror"
                    aria-describedby="photo-error" @error('photo') aria-invalid="true" @enderror
                    **aria-label="Wgraj zdjęcie dentysty" **>
                @error('photo')
                    <span class="text-red-700 text-sm" id="photo-error" role="alert">{{ $message }}</span>
                @enderror
                @if (isset($doctor) && $doctor->photo_url)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Aktualne zdjęcie:</p>
                        <img src="{{ asset($doctor->photo_url) }}" alt="{{ $doctor->photo_alt }}"
                            class="h-20 w-20 object-cover rounded">
                    </div>
                @endif
            </div>

            {{-- ALT zdjęcia --}}
            <div>
                <label for="photo_alt" class="block text-sm font-medium text-gray-700">Tekst alternatywny zdjęcia
                    (ALT)</label>
                <input type="text" name="photo_alt" id="photo_alt" placeholder="zdjecie lekarza o imieniu.."
                    value="{{ old('photo_alt', $doctor->photo_alt ?? '') }}"
                    class="border p-2 rounded w-full mt-1 @error('photo_alt') border-red-500 @enderror"
                    aria-describedby="photo_alt-error" @error('photo_alt') aria-invalid="true" @enderror
                    **aria-label="Tekst alternatywny dla zdjęcia dentysty" **>
                @error('photo_alt')
                    <span class="text-red-700 text-sm" id="photo_alt-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- Opis kariery zawodowej --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Opis (np. kariera zawodowa,
                    doświadczenie)</label>
                <textarea name="description" id="description" rows="4" placeholder="lekarz o imieniu osiągnął.."
                    class="border p-2 rounded w-full mt-1 @error('description') border-red-500 @enderror"
                    aria-describedby="description-error" @error('description') aria-invalid="true" @enderror
                    **aria-label="Opis kariery zawodowej i doświadczenia dentysty"
                    **>{{ old('description', $doctor->description ?? '') }}</textarea>
                @error('description')
                    <span class="text-red-700 text-sm" id="description-error" role="alert">{{ $message }}</span>
                @enderror
            </div>


            {{-- przyciski --}}
            <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#236DAA] hover:bg-[#1E5A90] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
                    {{ isset($doctor) ? 'Zapisz zmiany' : 'Dodaj dentystę' }}
                </button>

                <a href="{{ route('admin.dashboard', ['tab' => 'doctors']) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-[#13293D] font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base text-center">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
@endsection