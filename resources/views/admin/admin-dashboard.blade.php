<div x-data="{ tab: '{{ request()->get('tab', 'patients') }}', searchQuery: '{{ request()->get('search', '') }}' }">
    <section class="flex flex-col gap-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <nav aria-label="Sekcje panelu administracyjnego">
                <div class="flex flex-wrap gap-2">
                    <a :href="`{{ route('admin.dashboard', ['tab' => 'patients', 'page' => 1]) }}`"
                        :class="{ 'bg-[#236DAA] text-white': tab === 'patients' }"
                        class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                        Pacjenci
                    </a>
                    <a :href="`{{ route('admin.dashboard', ['tab' => 'doctors', 'page' => 1]) }}`"
                        :class="{ 'bg-[#236DAA] text-white': tab === 'doctors' }"
                        class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                        Dentyści
                    </a>
                    <a :href="`{{ route('admin.dashboard', ['tab' => 'appointments', 'page' => 1]) }}&search=${searchQuery}`"
                        :class="{ 'bg-[#236DAA] text-white': tab === 'appointments' }"
                        class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                        Wizyty
                    </a>
                    <a :href="`{{ route('admin.dashboard', ['tab' => 'reviews', 'page' => 1]) }}&search=${searchQuery}`"
                        :class="{ 'bg-[#236DAA] text-white': tab === 'reviews' }"
                        class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                        Opinie
                    </a>
                    <a :href="`{{ route('admin.dashboard', ['tab' => 'transactions', 'page' => 1]) }}&search=${searchQuery}`"
                        :class="{ 'bg-[#236DAA] text-white': tab === 'transactions' }"
                        class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                        Transakcje
                    </a>

                    <a :href="`{{ route('admin.dashboard', ['tab' => 'statistics']) }}`"
                        :class="{ 'bg-[#236DAA] text-white': tab === 'statistics' }"
                        class="px-3 py-2 text-sm md:text-base md:px-4 rounded-lg bg-gray-200 text-[#13293D] font-semibold whitespace-nowrap">
                        Statystyki
                    </a>
                </div>
            </nav>

            <div class="flex justify-end">
                <template x-if="tab === 'patients'">
                    <a href="{{ route('admin.patients.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 whitespace-nowrap">
                        Dodaj pacjenta
                    </a>
                </template>
                <template x-if="tab === 'doctors'">
                    <a href="{{ route('admin.doctors.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 whitespace-nowrap">
                        Dodaj dentystę
                    </a>
                </template>
                <template x-if="tab === 'appointments'">
                    <a href="{{ route('admin.appointments.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 whitespace-nowrap">
                        Dodaj wizytę
                    </a>
                </template>
                <template x-if="tab === 'reviews'">
                    <a href="{{ route('admin.reviews.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 whitespace-nowrap">
                        Dodaj opinię
                    </a>
                </template>
                <template x-if="tab === 'transactions'">
                    <a href="{{ route('admin.transactions.create') }}"
                        class="px-3 py-2 text-sm md:text-base md:px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 whitespace-nowrap">
                        Dodaj transakcję
                    </a>
                </template>
            </div>
        </div>

        <div class="my-2">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                <div class="flex">
                    <input type="text" name="search" x-model="searchQuery" placeholder="Szukaj..."
                        class="px-4 py-2 rounded-lg border w-full md:w-64 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <input type="hidden" name="tab" :value="tab">
                <button type="submit"
                    class="px-4 py-2 bg-blue-700 text-white rounded-lg whitespace-nowrap w-full md:w-auto hover:bg-blue-800">
                    Szukaj
                </button>
            </form>
        </div>

        <section x-show="tab === 'patients'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto"
            aria-labelledby="patients-heading">
            <h4 id="patients-heading" class="font-semibold text-[#13293D] mb-4">Pacjenci</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#236DAA] text-white">
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
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-2 px-4">{{ $patient->user->first_name }}</td>
                            <td class="py-2 px-4">{{ $patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $patient->user->email }}</td>
                            <td class="py-2 px-4">{{ $patient->phone_number }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.patients.edit', $patient->id) }}"
                                    class="text-blue-700 hover:text-blue-800 ml-4 font-medium">Edytuj</a>
                                <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-800 ml-4 font-medium"
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
        </section>

        <section x-show="tab === 'doctors'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto"
            aria-labelledby="doctors-heading">
            <h4 id="doctors-heading" class="font-semibold text-[#13293D] mb-4">Dentyści</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#236DAA] text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Imię</th>
                        <th class="py-2 px-4 text-left">Nazwisko</th>
                        <th class="py-2 px-4 text-left">Specjalizacja</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Nr telefonu</th>
                        <th class="py-2 px-4 text-left">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors ?? [] as $doctor)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-2 px-4">{{ $doctor->user->first_name }}</td>
                            <td class="py-2 px-4">{{ $doctor->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $doctor->specialization }}</td>
                            <td class="py-2 px-4">{{ $doctor->user->email }}</td>
                            <td class="py-2 px-4">{{ $doctor->phone_number }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                    class="text-blue-700 hover:text-blue-800 ml-4 font-medium">Edytuj</a>
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-800 ml-4 font-medium"
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
        </section>

        <section x-show="tab === 'appointments'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto"
            aria-labelledby="appointments-heading">
            <h4 id="appointments-heading" class="font-semibold text-[#13293D] mb-4">Wizyty</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#236DAA] text-white">
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
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-2 px-4">{{ $appointment->appointment_date }}</td>
                            <td class="py-2 px-4">{{ $appointment->patient->user->first_name }}
                                {{ $appointment->patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $appointment->doctor->user->first_name }}
                                {{ $appointment->doctor->user->last_name }}</td>
                            <td class="py-2 px-4">{{ __('db.appointment_statuses.' . $appointment->status) }}</td>
                            <td class="py-2 px-4">{{ __('db.visit_types.' . $appointment->visit_type) }}</td>
                            <td class="py-2 px-4">{{ $appointment->notes }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                                    class="text-blue-700 hover:text-blue-800 ml-4 font-medium">Edytuj</a>
                                <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-800 ml-4 font-medium"
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
        </section>

        <section x-show="tab === 'reviews'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto"
            aria-labelledby="reviews-heading">
            <h4 id="reviews-heading" class="font-semibold text-[#13293D] mb-4">Opinie</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#236DAA] text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Pacjent</th>
                        <th class="py-2 px-4 text-left">Dentysta</th>
                        <th class="py-2 px-4 text-left">Treść</th>
                        <th class="py-2 px-4 text-left">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews ?? [] as $review)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-2 px-4">{{ $review->patient->user->first_name }}
                                {{ $review->patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $review->doctor->user->first_name }}
                                {{ $review->doctor->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $review->content }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.reviews.edit', $review->id) }}"
                                    class="text-blue-700 hover:text-blue-800 ml-4 font-medium">Edytuj</a>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-800 ml-4 font-medium"
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
        </section>

        <section x-show="tab === 'transactions'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto"
            aria-labelledby="transactions-heading">
            <h4 id="transactions-heading" class="font-semibold text-[#13293D] mb-4">Transakcje</h4>
            <table class="min-w-full text-sm text-[#13293D] border mb-4">
                <thead class="bg-[#236DAA] text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Pacjent</th>
                        <th class="py-2 px-4 text-left">Zarezerwowana wizyta</th>
                        <th class="py-2 px-4 text-left">Kwota</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Data płatności</th>
                        <th class="py-2 px-4 text-left">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions ?? [] as $transaction)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-2 px-4">{{ $transaction->patient->user->first_name }}
                                {{ $transaction->patient->user->last_name }}</td>
                            <td class="py-2 px-4">{{ $transaction->appointment->doctor->user->first_name }}
                                {{ $transaction->appointment->doctor->user->last_name }}
                                ({{ \Carbon\Carbon::parse($transaction->appointment->appointment_date)->format('Y-m-d H:i') }})
                            </td>
                            <td class="py-2 px-4">{{ number_format($transaction->amount, 2, ',', ' ') }} zł</td>
                            <td class="py-2 px-4">{{ __('db.transaction_statuses.' . $transaction->status) }}</td>
                            <td class="py-2 px-4">
                                {{ $transaction->payment_date ? \Carbon\Carbon::parse($transaction->payment_date)->format('Y-m-d') : 'Brak' }}
                            </td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.transactions.edit', $transaction->id) }}"
                                    class="text-blue-700 hover:text-blue-800 ml-4 font-medium">Edytuj</a>
                                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-800 ml-4 font-medium"
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
        </section>

        <section x-show="tab === 'statistics'" x-cloak class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-bold text-[#13293D] mb-6">Statystyki Systemu</h3>

            @if ($statistics)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200">
                        <h4 class="text-lg font-semibold text-blue-800">Wizyty Odbyte</h4>
                        <p class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $statistics['total_completed_appointments'] }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
                        <h4 class="text-lg font-semibold text-green-800">Zarejestrowani Pacjenci</h4>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ $statistics['total_registered_patients'] }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg shadow-sm border border-purple-200">
                        <h4 class="text-lg font-semibold text-purple-800">Zarejestrowani Dentyści</h4>
                        <p class="text-3xl font-bold text-purple-600 mt-2">
                            {{ $statistics['total_registered_doctors'] }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg shadow-sm border border-yellow-200">
                        <h4 class="text-lg font-semibold text-yellow-800">Wszystkie Wizyty</h4>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $statistics['total_appointments'] }}</p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-lg shadow-sm border border-indigo-200">
                        <h4 class="text-lg font-semibold text-indigo-800">Opłacone Transakcje</h4>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">
                            {{ $statistics['total_paid_transactions'] }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-[#13293D] mb-4">Wizyty w ostatnich 7 dniach</h3>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
                    <canvas id="appointmentsChart"></canvas>
                </div>
            @else
                <p class="text-gray-600">Brak danych statystycznych do wyświetlenia.</p>
            @endif
        </section>
    </section>
</div>


@push('scripts')
    {{-- chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function initializeChart() {
            const currentTab = '{{ request()->get('tab', 'patients') }}';

            if (currentTab === 'statistics') {
                const statisticsData = @json($statistics ?? null);
                if (statisticsData && statisticsData.appointments_last_7_days && statisticsData.appointments_last_7_days
                    .length > 0) {
                    const appointmentsData = statisticsData.appointments_last_7_days;
                    const labels = appointmentsData.map(item => item.date);
                    const data = appointmentsData.map(item => item.count);
                    const ctx = document.getElementById('appointmentsChart');

                    if (ctx) {
                        if (Chart.getChart(ctx)) {
                            Chart.getChart(ctx).destroy();
                        }

                        new Chart(ctx.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Liczba wizyt',
                                    data: data,
                                    fill: true,
                                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgba(59, 130, 246, 1)'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Liczba wizyt w ostatnich 7 dniach',
                                        font: {
                                            size: 16
                                        },
                                        color: '#333'
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Liczba wizyt',
                                            font: {
                                                size: 14
                                            },
                                            color: '#555'
                                        },
                                        ticks: {
                                            precision: 0
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Data',
                                            font: {
                                                size: 14
                                            },
                                            color: '#555'
                                        },
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            }
        }
        window.onload = initializeChart;
    </script>
@endpush
