    <header class="bg-gradient-to-r from-[#13293D] to-[#2A628F] text-white py-4 shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-white">DentMax {{Auth::user()->role}}</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-[#3E92CC] hover:bg-[#62B6CB] text-white font-semibold py-2 px-4 rounded shadow">
                    Wyloguj się
                </button>
            </form>
        </div>
    </header>