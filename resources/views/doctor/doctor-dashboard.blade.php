<div x-data="{ tab: 'upcoming' }" class="flex flex-col gap-4">
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

    <div x-show="tab === 'upcoming'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Nadchodzące wizyty</h4>

        @forelse($upcomingAppointments as $appointment)
            <div class="p-4 rounded-lg bg-white shadow border-l-4 border-blue-400">
                <div class="flex flex-col gap-4">
                    <div class="space-y-2">
                        <h4 class="font-semibold text-lg text-[#13293D]">
                            Pacjent: {{ $appointment->patient->user->first_name }}
                            {{ $appointment->patient->user->last_name }}
                        </h4>
                        <p class="text-gray-700">Typ: {{ __('db.visit_types.' . $appointment->visit_type) }}</p>
                        <p class="text-gray-600">Data:
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}</p>

                        <p
                            class="text-sm font-medium {{ optional($appointment->transaction)->status === 'paid' ? 'text-green-700' : 'text-red-700' }}">
                            {{ optional($appointment->transaction)->status === 'paid' ? 'Wizyta opłacona' : 'Wizyta nieopłacona' }}
                        </p>
                    </div>

                    <div class="border-t pt-3">
                        <form method="POST" action="{{ route('doctor.appointment.reschedule', $appointment->id) }}"
                            class="flex flex-col gap-3 sm:flex-row sm:items-end" x-data="{
                                selectedDate: '{{ old('new_appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d')) }}',

                                selectedTime: '{{ old('new_appointment_time', \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i')) }}',

                                availableTimes: [],

                                doctorId: {{ $doctor->id }},

                                fetchAvailableTimes() {
                                    if (!this.selectedDate) {
                                        this.availableTimes = [];
                                        this.selectedTime = '';
                                        return;
                                    }
                                    fetch(`{{ route('doctor.appointments.available_slots') }}?date=${this.selectedDate}&doctor_id=${this.doctorId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            this.availableTimes = data;

                                            if (!this.availableTimes.includes(this.selectedTime)) {
                                                if (this.availableTimes.length > 0) {
                                                    this.selectedTime = this.availableTimes[0];
                                                } else {
                                                    this.selectedTime = '';
                                                }
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Błąd podczas pobierania dostępnych godzin:', error);
                                            this.availableTimes = [];
                                            this.selectedTime = '';
                                        });
                                }
                            }"
                            x-init="fetchAvailableTimes();
                            $watch('selectedDate', () => fetchAvailableTimes())">
                            @csrf
                            <div class="flex flex-col flex-grow gap-2">
                                <label for="new_date_{{ $appointment->id }}"
                                    class="whitespace-nowrap text-sm sm:text-base">Zmień datę i
                                    godzinę:</label>
                                <input type="date" id="new_date_{{ $appointment->id }}" name="new_appointment_date"
                                    x-model="selectedDate" class="border rounded p-2 w-full" required>

                                <select name="new_appointment_time" id="new_time_{{ $appointment->id }}"
                                    x-model="selectedTime" class="border rounded p-2 w-full mt-2" required>

                                    <template x-for="timeSlot in availableTimes" :key="timeSlot">
                                        <option :value="timeSlot" x-text="timeSlot"></option>
                                    </template>

                                    <template x-if="availableTimes.length === 0">
                                        <option disabled value="">Brak wolnych terminów</option>
                                    </template>
                                </select>
                            </div>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">
                                Zmień termin
                            </button>
                        </form>
                        @error('new_appointment_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @error('new_appointment_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-2 border-t pt-3 justify-start sm:justify-start">
                        <form action="{{ route('doctor.appointment.confirm', $appointment->id) }}" method="POST"
                            class="flex-none w-full sm:w-auto">
                            @csrf
                            <button type="submit"
                                class="{{ optional($appointment->transaction)->status === 'paid' ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 cursor-not-allowed' }} text-white px-4 py-2 rounded-md w-full"
                                {{ optional($appointment->transaction)->status !== 'paid' ? 'disabled' : '' }}
                                @if (optional($appointment->transaction)->status !== 'paid') title="Wizyta musi być opłacona" @endif>
                                Potwierdź
                            </button>
                        </form>

                        <form action="{{ route('doctor.appointment.cancel', $appointment->id) }}" method="POST"
                            class="flex-none w-full sm:w-auto">
                            @csrf
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md w-full">Anuluj</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Brak nadchodzących wizyt.</p>
        @endforelse
    </div>

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
                <p class="text-gray-700">Typ: {{ __('db.visit_types.' . $appointment->visit_type) }}</p>
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

    <div x-show="tab === 'canceled'" x-cloak class="bg-yellow-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Anulowane wizyty</h4>

        @forelse($canceledAppointments as $appointment)
            <div class="p-4 rounded-lg bg-white border-l-4 border-yellow-500 shadow">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    Pacjent: {{ $appointment->patient->user->first_name }}
                    {{ $appointment->patient->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ: {{ __('db.visit_types.' . $appointment->visit_type) }}</p>
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
