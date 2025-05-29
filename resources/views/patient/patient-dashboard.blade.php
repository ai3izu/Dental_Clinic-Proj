<div x-data="{ tab: 'upcoming' }" class="flex flex-col gap-4">
    <div class="flex flex-col md:flex-row gap-2 justify-between items-center">
        <div class="flex flex-wrap sm:flex-column gap-2">
            <button @click="tab = 'upcoming'" :class="tab === 'upcoming' ? 'bg-[#005691] text-white' : 'bg-gray-200 text-[#13293D]'" class="px-4 py-2 text-sm md:text-base rounded-lg font-semibold ">
                Moje wizyty
            </button>
            <button @click="tab = 'completed'" :class="tab === 'completed' ? 'bg-[#005691] text-white' : 'bg-gray-200 text-[#13293D]'" class="px-4 py-2 text-sm md:text-base rounded-lg font-semibold">
                Odbyte wizyty
            </button>
            <button @click="tab = 'canceled'" :class="tab === 'canceled' ? 'bg-[#005691] text-white' : 'bg-gray-200 text-[#13293D]'" class="px-4 py-2 text-sm md:text-base rounded-lg font-semibold">
                Anulowane wizyty
            </button>
        </div>
        <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
            <a href="{{ route('patient.complete-profile') }}"
                class="bg-[#005691] text-white px-4 py-2 rounded-lg font-semibold text-sm md:text-base whitespace-nowrap hover:bg-[#004777] transition-colors duration-300">
                Edytuj profil
            </a>
            <a href="{{ route('doctors.public') }}"
                class="bg-[#005691] text-white px-4 py-2 rounded-lg font-semibold text-sm md:text-base whitespace-nowrap hover:bg-[#004777] transition-colors duration-300">
                Umów wizytę
            </a>
        </div>
    </div>


    <!-- moje wizyty -->
    <div x-show="tab === 'upcoming'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Zaplanowane wizyty</h4>

        @forelse($upcoming as $appointment)
            <div
                class="p-4 rounded-lg shadow {{ !$appointment->is_paid ? 'bg-red-100 border-l-4 border-red-500' : 'bg-white' }}">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    dr {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ wizyty: {{ __('db.visit_types.' . $appointment->visit_type)}}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}
                </p>
                @if (optional($appointment->transaction)->status !== 'paid')
                    <p class="text-sm text-red-700 font-medium mt-1">Wizyta nieopłacona</p>
                @endif

                <!-- przycisk dla wizyt ktore nie sa anulowane ani zakonczone -->
                @if ($appointment->status !== 'canceled' && $appointment->status !== 'completed')
                    <div class="mt-4 flex flex-col sm:flex-row gap-4">
                        @if (!$appointment->isPaid())
                            <form action="{{ route('patient.appointment.pay', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 text-sm md:text-base rounded-lg font-semibold w-full sm:w-auto">
                                    Opłać wizytę
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="bg-gray-300 text-gray-600 px-4 py-2 text-sm md:text-base rounded-lg font-semibold w-full sm:w-auto cursor-not-allowed">
                                Wizyta opłacona
                            </button>

                        @endif

                        <form action="{{ route('patient.appointment.cancel', $appointment->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 text-sm md:text-base rounded-lg font-semibold w-full sm:w-auto">
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

    <!-- zakonczone / odbyte wizyty -->
    <div x-show="tab === 'completed'" x-cloak class="bg-green-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Odbyte wizyty</h4>

        @forelse($completed as $appointment)
            <div class="p-4 rounded-lg bg-white border-l-4 border-green-500 shadow">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    dr {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ wizyty: {{ __('db.visit_types.' . $appointment->visit_type) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}
                </p>
                <p class="text-sm text-green-700 font-medium mt-1">Wizyta opłacona</p>
            </div>
        @empty
            <p class="text-gray-500">Nie masz odbytych wizyt.</p>
        @endforelse
    </div>

    <!-- anulowane wizyty -->
    <div x-show="tab === 'canceled'" x-cloak class="bg-yellow-50 p-4 rounded-lg shadow space-y-4">
        <h4 class="font-semibold text-[#13293D] mb-4">Anulowane wizyty</h4>

        @forelse($canceled as $appointment)
            <div class="p-4 rounded-lg bg-white border-l-4 border-yellow-500 shadow">
                <h4 class="font-semibold text-lg text-[#13293D]">
                    dr {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}
                </h4>
                <p class="text-gray-700">Typ wizyty: {{ __('db.visit_types.' . $appointment->visit_type) }}</p>
                <p class="text-gray-600">Data:
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}
                </p>
                <p class="text-sm text-yellow-700 font-medium mt-1">Wizyta anulowana</p>
            </div>
        @empty
            <p class="text-gray-500">Nie masz anulowanych wizyt.</p>
        @endforelse
    </div>
</div>