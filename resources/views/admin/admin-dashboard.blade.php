<div x-data="{ tab: '{{ request()->get('tab', 'patients') }}', searchQuery: '{{ request()->get('search', '') }}' }">
    <!-- container -->
    <div class="flex flex-col gap-4">
        <!-- zakladki i przyciski-->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- zakladki  -->
            <div class="flex flex-wrap gap-2">
                <a :href="`{{ route('admin.dashboard', ['tab' => 'patients', 'page' => 1]) }}`"
                    :class="{ 'bg-[#3E92CC] text-white': tab === 'patients' }"
                    class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                    Pacjenci
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'doctors', 'page' => 1]) }}`"
                    :class="{ 'bg-[#3E92CC] text-white': tab === 'doctors' }"
                    class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                    Dentyści
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'appointments', 'page' => 1]) }}&search=${searchQuery}`"
                    :class="{ 'bg-[#3E92CC] text-white': tab === 'appointments' }"
                    class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                    Wizyty
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'reviews', 'page' => 1]) }}&search=${searchQuery}`"
                    :class="{ 'bg-[#3E92CC] text-white': tab === 'reviews' }"
                    class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                    Opinie
                </a>
                <a :href="`{{ route('admin.dashboard', ['tab' => 'transactions', 'page' => 1]) }}&search=${searchQuery}`"
                    :class="{ 'bg-[#3E92CC] text-white': tab === 'transactions' }"
                    class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                    Transakcje
                </a>
            </div>

            <!-- przyciski dodawania-->
            <div class="flex justify-end">
                <template x-if="tab === 'patients'">
                    <a href="{{ route('admin.patients.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 whitespace-nowrap">
                        Dodaj pacjenta
                    </a>
                </template>
                <template x-if="tab === 'doctors'">
                    <a href="{{ route('admin.doctors.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 whitespace-nowrap">
                        Dodaj dentystę
                    </a>
                </template>
                <template x-if="tab === 'appointments'">
                    <a href="{{ route('admin.appointments.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 whitespace-nowrap">
                        Dodaj wizytę
                    </a>
                </template>
                <template x-if="tab === 'reviews'">
                    <a href="{{ route('admin.reviews.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 whitespace-nowrap">
                        Dodaj opinię
                    </a>
                </template>
                <template x-if="tab === 'transactions'">
                    <a href="{{ route('admin.transactions.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 whitespace-nowrap">
                        Dodaj transakcję
                    </a>
                </template>
            </div>
        </div>

        <!-- searchbar -->
        <div class="my-2">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                <div class="flex">
                    <input type="text" name="search" x-model="searchQuery" placeholder="Szukaj..."
                        class="px-4 py-2 rounded-lg border w-full md:w-64">
                </div>
                <input type="hidden" name="tab" :value="tab">
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg whitespace-nowrap w-full md:w-auto">
                    Szukaj
                </button>
            </form>
        </div>

        <!-- Pacjenci -->
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
                                <a href="{{ route('admin.patients.edit', $patient->id) }}"
                                    class="text-blue-500 ml-4">Edytuj</a>
                                <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-4"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego pacjenta?')">Usuń</button>
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

        <!-- Dentyści -->
        <div x-show="tab === 'doctors'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
            <h4 class="font-semibold text-[#13293D] mb-4">Dentyści</h4>
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
                    @foreach ($doctors ?? [] as $doctor)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $doctor->user->first_name }}</td>
                            <td class="py-2 px-4">{{ $doctor->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $doctor->user->email }}</td>
                            <td class="py-2 px-4">{{ $doctor->phone_number }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                    class="text-blue-500 ml-4">Edytuj</a>
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-4"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego dentystę?')">Usuń</button>
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

        <!-- Wizyty -->
        <div x-show="tab === 'appointments'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
            <h4 class="font-semibold text-[#13293D] mb-4">Wizyty</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#3E92CC] text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Data</th>
                        <th class="py-2 px-4 text-left">Pacjent</th>
                        <th class="py-2 px-4 text-left">Dentysta</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Typ wizyty</th>
                        <th class="py-2 px-4 text-left">Notatki</th>
                        <th class="py-2 px-4 text-left">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments ?? [] as $appointment)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $appointment->appointment_date }}</td>
                            <td class="py-2 px-4">{{ $appointment->patient->user->first_name }}
                                {{ $appointment->patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $appointment->doctor->user->first_name }}
                                {{ $appointment->doctor->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $appointment->status }}</td>
                            <td class="py-2 px-4">{{ $appointment->visit_type }}</td>
                            <td class="py-2 px-4">{{ $appointment->notes }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                                    class="text-blue-500 ml-4">Edytuj</a>
                                <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-4"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tę wizytę?')">Usuń</button>
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

        <!-- Opinie -->
        <div x-show="tab === 'reviews'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
            <h4 class="font-semibold text-[#13293D] mb-4">Opinie</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#3E92CC] text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Pacjent</th>
                        <th class="py-2 px-4 text-left">Dentysta</th>
                        <th class="py-2 px-4 text-left">Treść</th>
                        <th class="py-2 px-4 text-left">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews ?? [] as $review)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $review->patient->user->first_name }}
                                {{ $review->patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $review->doctor->user->first_name }}
                                {{ $review->doctor->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $review->content }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.reviews.edit', $review->id) }}"
                                    class="text-blue-500 ml-4">Edytuj</a>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-4"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tę opinię?')">Usuń</button>
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

        <!-- Transakcje -->
        <div x-show="tab === 'transactions'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
            <h4 class="font-semibold text-[#13293D] mb-4">Transakcje</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#3E92CC] text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Pacjent</th>
                        <th class="py-2 px-4 text-left">Zarejestrowany u</th>
                        <th class="py-2 px-4 text-left">Kwota</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Data płatności</th>
                        <th class="py-2 px-4 text-left">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions ?? [] as $transaction)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $transaction->patient->user->first_name }}
                                {{ $transaction->patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $transaction->appointment->doctor->user->first_name }}
                                {{ $transaction->appointment->doctor->user->last_name }} {{$transaction->appointment->appointment_date}}</td>
                            <td class="py-2 px-4">{{ $transaction->amount }}</td>
                            <td class="py-2 px-4">{{ $transaction->status }}</td>
                            <td class="py-2 px-4">{{ $transaction->payment_date }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.transactions.edit', $transaction->id) }}"
                                    class="text-blue-500 ml-4">Edytuj</a>
                                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-4"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tę transakcję?')">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($transactions)
                <div>
                    {{ $transactions->appends(['tab' => 'transactions', 'search' => request()->get('search')])->links() }}
                </div>
            @endif
        </div>
    </div>
