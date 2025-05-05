<div class="min-h-[calc(100vh-160px)]"> <!-- wysokość dynamiczna: odejmuje header + footer -->
    <h3 class="text-xl font-bold text-[#13293D] mb-4">Zarządzanie systemem kliniki dentystycznej DentMax</h3>

    <div x-data="{ tab: 'patients' }" class="space-y-4">
        <!-- Zakładki -->
        <div class="flex space-x-4">
            <button @click="tab = 'patients'" :class="{ 'bg-[#3E92CC] text-white': tab === 'patients' }" class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                Pacjenci
            </button>
            <button @click="tab = 'doctors'" :class="{ 'bg-[#3E92CC] text-white': tab === 'doctors' }" class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                Dentyści
            </button>
            <button @click="tab = 'stats'" :class="{ 'bg-[#3E92CC] text-white': tab === 'stats' }" class="px-4 py-2 rounded-lg bg-gray-200 text-[#13293D] font-semibold">
                Statystyki
            </button>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $patient->user->first_name }}</td>
                        <td class="py-2 px-4">{{ $patient->user->last_name }}</td>
                        <td class="py-2 px-4">{{ $patient->user->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginacja -->
            <div>
                {{ $patients->links() }}
            </div>
        </div>

        <!-- Dentyści -->
        <div x-show="tab === 'doctors'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow">
            <h4 class="font-semibold text-[#13293D] mb-2">Dentyści</h4>
            <p class="text-sm text-[#13293D]">Tu będzie lista dentystów i przypisania pacjentów.</p>
        </div>

        <!-- Statystyki -->
        <div x-show="tab === 'stats'" x-cloak class="bg-[#EAF6FF] p-4 rounded-lg shadow">
            <h4 class="font-semibold text-[#13293D] mb-4">Statystyki systemu</h4>
            <canvas id="statsChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
