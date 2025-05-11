<div x-data="{ tab: '{{ request()->get('tab', 'patients') }}', searchQuery: '{{ request()->get('search', '') }}' }">
    <div class="flex flex-wrap items-center justify-between space-y-2 md:space-y-0">
        <!-- sekcja z zakladkami -->
        <div class="flex flex-wrap items-center space-x-2">
            <div class="flex space-x-2">
                <a :href="`{{ route('admin.dashboard', ['tab' => 'patients', 'page' => 1]) }}`"
                   :class="{ 'bg-[#3E92CC] text-white': tab === 'patients' }"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                    Pacjenci
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'doctors', 'page' => 1]) }}`"
                   :class="{ 'bg-[#3E92CC] text-white': tab === 'doctors' }"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                    Dentyści
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'appointments', 'page' => 1]) }}&search=${searchQuery}`"
                   :class="{ 'bg-[#3E92CC] text-white': tab === 'appointments' }"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                    Wizyty
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'reviews', 'page' => 1]) }}&search=${searchQuery}`"
                    :class="{ 'bg-[#3E92CC] text-white': tab === 'reviews' }"
                    class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                     Opinie
                 </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'stats', 'page' => 1]) }}&search=${searchQuery}`"
                   :class="{ 'bg-[#3E92CC] text-white': tab === 'stats' }"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                    Statystyki
                </a>
            </div>
        </div>

        <!-- sekcja z przyciskami do dodawania-->
        <div>
            <template x-if="tab === 'patients'">
                <a href="{{ route('admin.patients.create') }}"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600">
                    Dodaj nowego pacjenta
                </a>
            </template>
            <template x-if="tab === 'doctors'">
                <a href="{{ route('admin.doctors.create') }}"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600">
                    Dodaj nowego dentystę
                </a>
            </template>
            <template x-if="tab === 'appointments'">
                <a href="{{ route('admin.appointments.create') }}"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600">
                    Dodaj nową wizytę
                </a>
            </template>
            <template x-if="tab === 'reviews'">
                <a href="{{ route('admin.reviews.create')}}"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600">
                    Dodaj nową opinię
                </a>
            </template>
        </div>
    </div>

    <!-- sreachbar -->
    <div class="my-4">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex space-x-2">
            <input type="text" name="search" x-model="searchQuery" placeholder="Szukaj..."
                   class="px-4 py-2 rounded-lg border w-64">
            <input type="hidden" name="tab" :value="tab">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Szukaj</button>
        </form>
    </div>

    <!-- zakladka z pacjentami -->
    <div x-show="tab === 'patients'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
        <h4 class="font-semibold text-[#13293D] mb-4">Pacjenci</h4>
        <table class="min-w-full text-sm text-[#13293D] border mb-4">
            <thead class="bg-[#3E92CC] text-white">
                <tr>
                    <th class="py-2 px-4 text-left">Imię</th>
                    <th class="py-2 px-4 text-left">Nazwisko</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Nr telefonu</th>
                    <th class="py-2 px-4 text-left">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients ?? [] as $patient)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $patient->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $patient->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $patient->user->email }}</td>
                        <td class="py-2 px-4">{{ $patient->phone_number }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.patients.edit', $patient->id) }}" class="text-blue-500 ml-4">Edytuj</a>
                            <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-4" onclick="return confirm('Czy na pewno chcesz usunąć tego pacjenta?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($patients)
            <div>
                {{ $patients->appends(['tab' => 'patients', 'search' => request()->get('search')])->links() }}
            </div>
        @endif
    </div>

    <!-- zakladka z dentystami -->
    <div x-show="tab === 'doctors'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
        <h4 class="font-semibold text-[#13293D] mb-4">Dentyści</h4>
        <table class="min-w-full text-sm text-[#13293D] border mb-4">
            <thead class="bg-[#3E92CC] text-white">
                <tr>
                    <th class="py-2 px-4 text-left">Imię</th>
                    <th class="py-2 px-4 text-left">Nazwisko</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors ?? [] as $doctor)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $doctor->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $doctor->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $doctor->user->email }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="text-blue-500 ml-4">Edytuj</a>
                            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-4" onclick="return confirm('Czy na pewno chcesz usunąć tego pacjenta?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($doctors)
            <div>
                {{ $doctors->appends(['tab' => 'doctors', 'search' => request()->get('search')])->links() }}
            </div>
        @endif
    </div>

    <!-- zakladka z wizytami  -->
    <div x-show="tab === 'appointments'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
        <h4 class="font-semibold text-[#13293D] mb-4">Wizyty</h4>
        <table class="min-w-full text-sm text-[#13293D] border mb-4">
            <thead class="bg-[#3E92CC] text-white">
                <tr>
                    <th class="py-2 px-4 text-left">Imię Pacjenta</th>
                    <th class="py-2 px-4 text-left">Nazwisko Pacjenta</th>
                    <th class="py-2 px-4 text-left">Imię Dentysty</th>
                    <th class="py-2 px-4 text-left">Nazwisko Dentysty</th>
                    <th class="py-2 px-4 text-left">Data wizyty</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Typ wizyty</th>
                    <th class="py-2 px-4 text-left">Opis wizyty</th>
                    <th class="py-2 px-4 text-left">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments ?? [] as $appointment)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $appointment->patient->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $appointment->patient->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $appointment->doctor->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $appointment->doctor->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $appointment->appointment_date }}</td>
                        <td class="py-2 px-4">{{ $appointment->status }}</td>
                        <td class="py-2 px-4">{{ $appointment->visit_type }}</td>
                        <td class="py-2 px-4">{{ $appointment->notes }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="text-blue-500 ml-4">Edytuj</a>
                            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-4" onclick="return confirm('Czy na pewno chcesz usunąć tego pacjenta/tego lekarza i powiązane wizyty?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($appointments)
            <div>
                {{ $appointments->appends(['tab' => 'appointments', 'search' => request()->get('search')])->links() }}
            </div>
        @endif
    </div>

    <!-- zakladka z opiniami  -->
    <div x-show="tab === 'reviews'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
        <h4 class="font-semibold text-[#13293D] mb-4">Opinie</h4>
        <table class="min-w-full text-sm text-[#13293D] border mb-4">
            <thead class="bg-[#3E92CC] text-white">
                <tr>
                    <th class="py-2 px-4 text-left">Imię Pacjenta</th>
                    <th class="py-2 px-4 text-left">Nazwisko Pacjenta</th>
                    <th class="py-2 px-4 text-left">Treść opinii</th>
                    <th class="py-2 px-4 text-left">Dentysta</th>
                    <th class="py-2 px-4 text-left">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews ?? [] as $review)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $review->patient->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $review->patient->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $review->content  }}</td>
                        <td class="py-2 px-4">{{ $review->doctor->user->first_name }} {{ $review->doctor->user->last_name }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="text-blue-500 ml-4">Edytuj</a>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-4" onclick="return confirm('Czy na pewno chcesz usunąć tą opinię??')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($reviews)
            <div>
                {{ $reviews->appends(['tab' => 'reviews', 'search' => request()->get('search')])->links() }}
            </div>
        @endif
    </div>

    <!-- statystyki - dodac jscharts -->
    <div x-show="tab === 'stats'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow">
        <h4 class="font-semibold text-[#13293D] mb-4">Statystyki systemu</h4>
        <canvas id="statsChart" width="400" height="200"></canvas>
    </div>
</div>
        