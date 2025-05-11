@extends('layouts.app')

@section('content')
    {{-- container na wszystko --}}
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($review) ? 'Edytuj opinię' : 'Dodaj nową opinię' }}
        </h2>

        {{-- komunikaty o błedach --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- caly formularz --}}
        <form method="POST"
            action="{{ isset($review) ? route('admin.reviews.update', $review->id) : route('admin.reviews.store') }}"
            class="space-y-4">

            @csrf
            @if(isset($review))
                @method('PUT')
            @endif

            {{-- select do wybierania dentystow --}}
            <div>
                <label for="doctor_id" class="block text-sm font-medium text-gray-700">Lekarz</label>
                <select name="doctor_id" id="doctor_id" required class="border p-2 rounded w-full" {{ isset($review) ? 'disabled' : '' }}>
                    <option value="">Wybierz lekarza</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $review->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                        </option>
                    @endforeach
                </select>
                @if(isset($review))
                    <input type="hidden" name="doctor_id" value="{{ $review->doctor_id }}">
                @endif
                @error('doctor_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- select do wybierania pacjentow --}}
            <div>
                <label for="patient_id" class="block text-sm font-medium text-gray-700">Pacjent</label>
                <select name="patient_id" id="patient_id" required class="border p-2 rounded w-full" {{ isset($review) ? 'disabled' : '' }}>
                    <option value="">Wybierz pacjenta</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id', $review->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                        </option>
                    @endforeach
                </select>
                @if(isset($review))
                    <input type="hidden" name="patient_id" value="{{ $review->patient_id }}">
                @endif
                @error('patient_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- tresc do opinii --}}
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Treść opinii</label>
                <textarea name="content" id="content"
                    class="border p-2 rounded w-full">{{ old('content', $review->content ?? '') }}</textarea>
                @error('content')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- przyciski --}}
            <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#3E92CC] hover:bg-[#2f6ea3] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
                    {{ isset($review) ? 'Zapisz zmiany' : 'Dodaj opinię' }}
                </button>

                <a href="{{ route('admin.dashboard', ['tab' => 'reviews']) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-[#13293D] font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base text-center">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
@endsection