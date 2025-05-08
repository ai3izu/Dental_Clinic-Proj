@extends('layouts.app')

@section('content')
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">Dodawanie nowego pacjenta</h2>
        <form method="POST" action="{{ route('admin.patients.store') }}" class="space-y-4">
            @csrf
            <input name="first_name" placeholder="Imię" required class="border p-2 rounded w-full">
            <input name="last_name" placeholder="Nazwisko" required class="border p-2 rounded w-full">
            <input name="email" type="email" placeholder="Email" required class="border p-2 rounded w-full">
            <input name="phone_number" placeholder="Numer telefonu" class="border p-2 rounded w-full">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Dodaj pacjenta</button>
        </form>
    </div>
@endsection
