<div x-data="{ tab: 'upcoming' }" class="flex flex-col gap-4">
    <!-- Zakładki -->
    <div class="flex flex-col md:flex-row gap-2">
        <div class="flex flex-wrap sm:flex-column gap-2">
            <button @click="tab = 'upcoming'"
                :class="tab === 'upcoming' ? 'bg-[#3E92CC] text-white' : 'bg-gray-200 text-[#13293D]'"
                class="px-4 py-2 text-sm md:text-base rounded-lg font-semibold">
                Moje wizyty
            </button>
            <button @click="tab = 'completed'"
                :class="tab === 'completed' ? 'bg-[#3E92CC] text-white' : 'bg-gray-200 text-[#13293D]'"
                class="px-4 py-2 text-sm md:text-base rounded-lg font-semibold">
                Odbyte wizyty
            </button>
            <button @click="tab = 'canceled'"
                :class="tab === 'canceled' ? 'bg-[#3E92CC] text-white' : 'bg-gray-200 text-[#13293D]'"
                class="px-4 py-2 text-sm md:text-base rounded-lg font-semibold">
                Anulowane wizyty
            </button>
        </div>
        <!-- Przycisk Umów wizytę -->
        <a href="{{ route('doctors.public') }}"
            class="md:ml-auto bg-[#3E92CC] text-white px-4 py-2 rounded-lg font-semibold text-sm md:text-base">
            Umów wizytę
        </a>
    </div>

    <!-- Reszta kodu pozostaje bez zmian -->
    <!-- Moje wizyty -->
    <div x-show="tab === 'upcoming'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Zaplanowane wizyty</h4>

        @forelse($upcoming as $appointment)
            <div
                class="p-4 rounded-lg shadow {{ !$appointment->is_paid ? 'bg-red-100 border-l-4 border-red-500' : 'bg-white' }}">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    dr {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ wizyty: {{ ucfirst(__($appointment->visit_type)) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>
                @if (optional($appointment->transaction)->status !== 'paid')
                    <p class="text-sm text-red-700 font-medium mt-1">Wizyta nieopłacona</p>
                @endif

                <!-- Przycisk Opłać i Anuluj tylko dla wizyt, które nie są anulowane ani zakończone -->
                @if ($appointment->status !== 'canceled' && $appointment->status !== 'completed')
                    <div class="mt-4 flex flex-col sm:flex-row gap-4">
                        <!-- Przycisk "Opłać" zmienia status na 'paid' -->
                        <form action="{{ route('patient.appointment.pay', $appointment->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">
                                Opłać wizytę
                            </button>
                        </form>

                        <!-- Przycisk "Anuluj" zmienia status na 'canceled' -->
                        <form action="{{ route('patient.appointment.cancel', $appointment->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                                Anuluj wizytę
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Nie masz zaplanowanych wizyt.</p>
        @endforelse
    </div>

    <div x-show="tab === 'completed'" x-cloak class="bg-green-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Odbyte wizyty</h4>

        @forelse($completed as $appointment)
            <div class="p-4 rounded-lg bg-white border-l-4 border-green-500 shadow">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    dr {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ wizyty: {{ ucfirst(__($appointment->visit_type)) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>
                <p class="text-sm text-green-700 font-medium mt-1">Wizyta opłacona</p>
            </div>
        @empty
            <p class="text-gray-500">Nie masz odbytych wizyt.</p>
        @endforelse
    </div>

    <!-- Anulowane wizyty -->
    <div x-show="tab === 'canceled'" x-cloak class="bg-yellow-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Anulowane wizyty</h4>

        @forelse($canceled as $appointment)
            <div class="p-4 rounded-lg bg-white border-l-4 border-yellow-500 shadow">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    dr {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ wizyty: {{ ucfirst(__($appointment->visit_type)) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>
                <p class="text-sm text-yellow-700 font-medium mt-1">Wizyta anulowana</p>
            </div>
        @empty
            <p class="text-gray-500">Nie masz anulowanych wizyt.</p>
        @endforelse
    </div>
</div>
