@extends('layouts.app')

@section('content')
    {{-- container na wszystko --}}
    <div
        class="bg-[#EAF6FF] p-4 sm:p-5 md:p-6 rounded-2xl shadow max-w-full sm:max-w-xl md:max-w-2xl mx-auto my-8 sm:my-10 md:my-12">
        <h2 class="text-xl sm:text-2xl font-bold text-[#13293D] mb-5 sm:mb-6">
            {{ isset($transaction) ? 'Edytuj transakcję' : 'Dodaj nową transakcję' }}
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
            action="{{ isset($transaction) ? route('admin.transactions.update', $transaction->id) : route('admin.transactions.store') }}"
            class="space-y-4">
            @csrf
            @if(isset($transaction))
                @method('PUT')
            @endif

            {{-- select do wybierania wizyt --}}
            <div>
                <label for="appointment_id" class="block text-sm font-medium text-gray-700">Wizyta</label>
                <select name="appointment_id" id="appointment_id" required class="border p-2 rounded w-full" {{ isset($transaction) ? 'disabled' : '' }}>
                    <option value="">Wybierz wizytę</option>
                    @foreach($appointments as $appointment)
                        <option value="{{ $appointment->id }}" {{ old('appointment_id', $transaction->appointment_id ?? '') == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                            — {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}
                            ({{ $appointment->appointment_date }})
                        </option>
                    @endforeach
                </select>
                @if(isset($transaction))
                    <input type="hidden" name="appointment_id" value="{{ $transaction->appointment_id }}">
                @endif
                @error('appointment_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- kwota transakcji --}}
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Kwota</label>
                <input type="number" name="amount" id="amount" required step="0.01" class="border p-2 rounded w-full"
                    value="{{ old('amount', $transaction->amount ?? '') }}">
                @error('amount')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- select do wybierania statusu transakcji --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" required class="border p-2 rounded w-full">
                    <option value="paid" {{ old('status', $transaction->status ?? '') === 'paid' ? 'selected' : '' }}>Opłacona
                    </option>
                    <option value="unpaid" {{ old('status', $transaction->status ?? '') === 'unpaid' ? 'selected' : '' }}>
                        Nieopłacona
                    </option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- data transakcji --}}
            <div>
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Data płatności</label>
                <input type="date" name="payment_date" id="payment_date" class="border p-2 rounded w-full"
                    value="{{ old('payment_date', isset($transaction->payment_date) ? \Carbon\Carbon::parse($transaction->payment_date)->format('Y-m-d') : '') }}">
                @error('payment_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- przyciski --}}
            <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                <button type="submit"
                    class="bg-[#3E92CC] hover:bg-[#2f6ea3] text-white font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base">
                    {{ isset($transaction) ? 'Zapisz zmiany' : 'Dodaj transakcję' }}
                </button>

                <a href="{{ route('admin.dashboard', ['tab' => 'transactions']) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-[#13293D] font-semibold px-5 py-2 rounded-lg shadow text-sm sm:text-base text-center">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
@endsection