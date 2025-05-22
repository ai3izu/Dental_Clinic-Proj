<div x-data="{ tab: 'upcoming' }" class="flex flex-col gap-4">
    <!-- Zakładki -->
    <div class="flex flex-wrap sm:flex-row gap-2">
        <button @click="tab = 'upcoming'"
            :class="tab === 'upcoming' ? 'bg-[#3E92CC] text-white' : 'bg-gray-200 text-[#13293D]'"
            class="px-4 py-2 rounded-lg font-semibold">
            Nadchodzące wizyty
        </button>
        <button @click="tab = 'completed'"
            :class="tab === 'completed' ? 'bg-[#3E92CC] text-white' : 'bg-gray-200 text-[#13293D]'"
            class="px-4 py-2 rounded-lg font-semibold">
            Zakończone wizyty
        </button>
        <button @click="tab = 'canceled'"
            :class="tab === 'canceled' ? 'bg-[#3E92CC] text-white' : 'bg-gray-200 text-[#13293D]'"
            class="px-4 py-2 rounded-lg font-semibold">
            Anulowane wizyty
        </button>
    </div>

    <!-- Nadchodzące wizyty -->
    <div x-show="tab === 'upcoming'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Nadchodzące wizyty</h4>

        @forelse($upcomingAppointments as $appointment)
            <div class="p-4 rounded-lg bg-white shadow border-l-4 border-blue-400 space-y-2">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    Pacjent: {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ: {{ ucfirst(__($appointment->visit_type)) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>

                <div class="flex flex-wrap gap-2 mt-3">
                    <!-- Potwierdzenie -->
                    <form action="{{ route('doctor.appointment.confirm', $appointment->id) }}" method="POST">
                        @csrf
                        <button
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">Potwierdź</button>
                    </form>

                    <!-- Anuluj -->
                    <form action="{{ route('doctor.appointment.cancel', $appointment->id) }}" method="POST">
                        @csrf
                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Anuluj</button>
                    </form>

                    <!-- Zmień termin -->
                    <form method="POST" action="{{ route('doctor.appointment.reschedule', $appointment->id) }}">
                        @csrf
                        <label for="new_date">Zmień datę i godzinę:</label>
                        <input type="datetime-local" name="appointment_date" min="{{ now()->format('Y-m-d\TH:00') }}"
                            required
                            value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
                            class="mt-1 border rounded p-2 w-full" />
                        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Zmień termin
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Brak nadchodzących wizyt.</p>
        @endforelse
    </div>

    <!-- Zakończone wizyty -->
    <div x-show="tab === 'completed'" x-cloak class="bg-green-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Zakończone wizyty</h4>

        @forelse($completedAppointments as $appointment)
            <div
                class="p-4 rounded-lg bg-white shadow border-l-4
                {{ optional($appointment->transaction)->status === 'paid' ? 'border-green-500' : 'border-red-500' }}">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    Pacjent: {{ $appointment->patient->user->first_name }}
                    {{ $appointment->patient->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ: {{ ucfirst(__($appointment->visit_type)) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>
                <p
                    class="text-sm font-medium {{ optional($appointment->transaction)->status === 'paid' ? 'text-green-700' : 'text-red-700' }}">
                    {{ optional($appointment->transaction)->status === 'paid' ? 'Wizyta opłacona' : 'Wizyta nieopłacona' }}
                </p>

                @if (optional($appointment->transaction)->status === 'paid')
                    <a href="{{ route('doctor.notes.form', $appointment->id) }}"
                        class="mt-3 inline-block bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                        Notatki
                    </a>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Brak zakończonych wizyt.</p>
        @endforelse
    </div>

    <!-- Anulowane wizyty -->
    <div x-show="tab === 'canceled'" x-cloak class="bg-yellow-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Anulowane wizyty</h4>

        @forelse($canceledAppointments as $appointment)
            <div class="p-4 rounded-lg bg-white border-l-4 border-yellow-500 shadow">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    Pacjent: {{ $appointment->patient->user->first_name }}
                    {{ $appointment->patient->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ: {{ ucfirst(__($appointment->visit_type)) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>
                <form action="{{ route('doctor.appointment.restore', $appointment->id) }}" method="POST"
                    class="mt-3">
                    @csrf
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Przywróć</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">Brak anulowanych wizyt.</p>
        @endforelse
    </div>
</div>
