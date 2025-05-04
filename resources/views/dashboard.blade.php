@extends('layouts.app')

@section('title', 'Panel główny')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-[#13293D] mb-6">Witaj, {{ Auth::user()->first_name }}!</h2>

        @if(Auth::user()->role === 'admin')
        @include('partials.admin-dashboard')
        @elseif(Auth::user()->role === 'doctor')
        @include('partials.doctor-dashboard')
        @elseif(Auth::user()->role === 'patient')
        @include('partials.patient-dashboard')
        @else
        <p class="text-red-500">Nie masz uprawnień do tego panelu.</p>
        @endif
    </div>
</div>
@endsection