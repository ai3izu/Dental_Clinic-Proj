<div x-data="{ tab: '{{ request()->get('tab', 'patients') }}', searchQuery: '' }">
    <!-- Zakładki -->
    <div class="flex space-x-4">
        <!-- Pacjenci -->
        <a href="{{ route('admin.dashboard', ['tab' => 'patients', 'page' => 1]) }}"
            :class="{ 'bg-[#3E92CC] text-white': tab === 'patients' }"
            class="px-4 py-2 my-1 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
            Pacjenci
        </a>
        <!-- Dentyści -->
        <a href="{{ route('admin.dashboard', ['tab' => 'doctors', 'page' => 1]) }}"
            :class="{ 'bg-[#3E92CC] text-white': tab === 'doctors' }"
            class="px-4 py-2 my-1 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
            Dentyści
        </a>
        <!-- Statystyki -->
        <a href="{{ route('admin.dashboard', ['tab' => 'stats', 'page' => 1]) }}"
            :class="{ 'bg-[#3E92CC] text-white': tab === 'stats' }"
            class="px-4 py-2 my-1 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
            Statystyki
        </a>
    </div>

    <!-- Pasek wyszukiwania -->
    <div class="my-4">
        <input type="text" x-model="searchQuery" placeholder="Szukaj..." class="px-4 py-2 rounded-lg border">
    </div>

    <!-- Pacjenci -->
    <div x-show="tab === 'patients'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
        <h4 class="font-semibold text-[#13293D] mb-4">Pacjenci</h4>

        <!-- Filtracja wyników -->
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
                @foreach ($patients as $patient)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $patient->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $patient->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $patient->user->email }}</td>
                        <td class="py-2 px-4">{{ $patient->phone_number }}</td>
                        <td class="py-2 px-4">
                            <a href="#" class="text-blue-500">Edytuj</a>
                            <form action="{{ route('admin.patient.destroy', $patient->id) }}" method="POST"
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

        <!-- Paginacja -->
        <div>
            {{ $patients->appends(['tab' => 'patients'])->links() }}
        </div>
    </div>

    <!-- Dentyści -->
    <div x-show="tab === 'doctors'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow overflow-auto">
        <h4 class="font-semibold text-[#13293D] mb-4">Dentyści</h4>

        <!-- Filtracja wyników -->
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
                @foreach ($doctors as $doctor)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $doctor->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $doctor->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $doctor->user->email }}</td>
                        <td class="py-2 px-4">
                            <a href="#" class="text-blue-500">Edytuj</a>
                            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
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

        <!-- Paginacja -->
        <div>
            {{ $doctors->appends(['tab' => 'doctors'])->links() }}
        </div>
    </div>

    <!-- Statystyki -->
    <div x-show="tab === 'stats'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow">
        <h4 class="font-semibold text-[#13293D] mb-4">Statystyki systemu</h4>
        <canvas id="statsChart" width="400" height="200"></canvas>
    </div>
</div>
