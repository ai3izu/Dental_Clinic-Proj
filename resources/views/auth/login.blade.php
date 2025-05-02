<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - DentMax</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --color-1: #3E92CC;
            --color-2: #2A628F;
            --color-3: #13293D;
            --color-4: #16324F;
            --color-5: #18435A;
            --color-orange-50: oklch(0.98 0.016 73.684);
            --color-orange-100: oklch(0.954 0.038 75.164);
            --color-orange-200: oklch(0.901 0.076 70.697);
            --color-orange-300: oklch(0.837 0.128 66.29);
            --color-orange-400: oklch(0.75 0.183 55.934);
            --color-orange-500: oklch(0.705 0.213 47.604);
            --color-orange-600: oklch(0.646 0.222 41.116);
            --color-orange-700: oklch(0.553 0.195 38.402);
            --color-orange-800: oklch(0.47 0.157 37.304);
            --color-orange-900: oklch(0.408 0.123 38.172);
            --color-orange-950: oklch(0.266 0.079 36.259);
            --color-yellow-50: oklch(0.987 0.026 102.212);
            --color-yellow-100: oklch(0.973 0.071 103.193);
            --color-yellow-200: oklch(0.945 0.129 101.54);
            --color-yellow-300: oklch(0.905 0.182 98.111);
            --color-yellow-400: oklch(0.852 0.199 91.936);
            --color-yellow-500: oklch(0.795 0.184 86.047);
            --color-yellow-600: oklch(0.681 0.162 75.834);
            --color-yellow-700: oklch(0.554 0.135 66.442);
            --color-yellow-800: oklch(0.476 0.114 61.907);
            --color-yellow-900: oklch(0.421 0.095 57.708);
            --color-yellow-950: oklch(0.286 0.066 53.813);
            --color-gray-50: oklch(0.985 0 0);
            --color-gray-100: oklch(0.967 0.001 286.375);
            --color-gray-200: oklch(0.92 0.004 286.32);
            --color-gray-300: oklch(0.871 0.006 286.286);
            --color-gray-400: oklch(0.705 0.015 286.067);
            --color-gray-500: oklch(0.552 0.016 285.938);
            --color-gray-600: oklch(0.442 0.017 285.786);
            --color-gray-700: oklch(0.37 0.013 285.805);
            --color-gray-800: oklch(0.274 0.006 286.033);
            --color-gray-900: oklch(0.21 0.006 285.885);
            --color-gray-950: oklch(0.141 0.005 285.823);
        }

        .achievement {
            display: flex;
            position: relative;
            align-items: center;
            justify-content: flex-start;
            gap: 1rem;
            padding-right: 2.5rem;
            border-radius: 3rem;
            background-color: var(--color-3);
            color: var(--color-gray-300);
            border: 1px solid var(--color-2);
            margin: 0 auto;
            margin-bottom: 1.5rem;
            width: 80%;
            max-width: 450px;
            transform: translateY(-20px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .icon-outer-container {
            position: relative;
        }

        .icon-inner-container {
            position: relative;
            display: grid;
            place-items: center;
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background-image: radial-gradient(circle at center, var(--color-1) 80%, var(--color-3) 100%);
            z-index: 1;
            overflow: hidden;
        }

        .icon {
            display: grid;
            place-items: center;
            width: 3rem;
            height: 3rem;
            padding: 0.6rem;
            border-radius: inherit;
            background-color: var(--color-2);
            box-shadow: 0 0 10px hsl(from var(--color-5) h s l / 60%) inset, 0 2px 2px hsl(from var(--color-5) h s l / 30%) inset,
                1px 1px 1px hsl(from var(--color-1) h s l / 50%);
        }

        .icon svg {
            width: 100%;
            height: 100%;
            color: white;
            filter: drop-shadow(0 0 2px var(--color-3));
        }

        .spark-container {
            position: absolute;
            inset: 0;
            z-index: 3;
        }

        .spark {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: calc(var(--spark-size) / 2 * -1);
            margin-left: calc(var(--spark-size) / 2 * -1);
            color: white;
            transform-origin: center center;
            animation: spark-animation 5s calc(var(--delay, 0ms) + 700ms) linear both infinite;
        }

        .spark svg {
            width: var(--spark-size);
            height: var(--spark-size);
        }

        .highlight {
            --h-color: hsla(70, 20%, 96%, 0.7);
            --h-angle: 120deg;
            --h-gap: 4px;
            --h-1-size: 4px;
            --h-2-size: 12px;
            --h-start: 40%;
            --h-1-pos: calc(var(--h-start) + var(--h-1-size));
            --h-2-pos: calc(var(--h-start) + var(--h-gap) + var(--h-1-size));
            --h-end: calc(var(--h-start) + var(--h-gap) + var(--h-1-size) + var(--h-2-size));
            content: "";
            position: absolute;
            inset: 0rem;
            z-index: -1;
            will-change: transform;
            animation: slide 5s ease-in-out both infinite;
            background-image: linear-gradient(var(--h-angle), transparent var(--h-start), var(--h-color) var(--h-start),
                    var(--h-color) var(--h-1-pos), transparent var(--h-1-pos), transparent var(--h-2-pos), var(--h-color) var(--h-2-pos), var(--h-color) var(--h-end), transparent var(--h-end));
        }

        .content {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }

        .title {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.25;
            color: white;
        }

        .description {
            font-size: 0.875rem;
            line-height: 1.5;
            font-weight: 400;
            opacity: 0.75;
            color: #ddd;
        }

        @keyframes slide {
            0% {
                transform: translateX(-100%);
            }

            50%,
            100% {
                transform: translateX(100%);
            }
        }

        @keyframes spark-animation {
            0% {
                transform: scale(0) rotate(-180deg);
            }

            8% {
                transform: scale(1) rotate(0deg);
            }

            12% {
                transform: scale(1) rotate(90deg);
            }

            16%,
            100% {
                transform: scale(0) rotate(180deg);
            }
        }

        @media (max-width: 640px) {
            .achievement .title {
                font-size: 0.875rem;
            }

            .achievement .description {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-b from-[#3E92CC] to-[#62B6CB] h-screen flex items-center justify-center flex-col">

    <div class="achievement">
        <div class="icon-outer-container ">
            <div class="spark-container">
                <div class="spark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12c6.268 0 9-2.637 9-9c0 6.363 2.713 9 9 9c-6.287 0-9 2.713-9 9c0-6.287-2.732-9-9-9Z" />
                    </svg>
                </div>
                <div class="spark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12c6.268 0 9-2.637 9-9c0 6.363 2.713 9 9 9c-6.287 0-9 2.713-9 9c0-6.287-2.732-9-9-9Z" />
                    </svg>
                </div>
                <div class="spark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12c6.268 0 9-2.637 9-9c0 6.363 2.713 9 9 9c-6.287 0-9 2.713-9 9c0-6.287-2.732-9-9-9Z" />
                    </svg>
                </div>
            </div>
            <div class="icon-inner-container">
                <div class="highlight"></div>
                <div class="icon">
                    <div class="highlight" style="opacity: 0.25; z-index: 2;"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px"
                        fill="#FFFFFF">
                        <path
                            d="M680-875q66 0 113 47t47 113q0 11-1.5 29.5T834-643l-55 403q-5 38-34.5 62T677-154q-23 0-42.5-10T602-192L495-348q-2-4-6.5-5.5T479-355q-4 0-16 9L359-195q-14 20-34.5 30.5T281-154q-38 0-67-24.5T180-241l-54-402q-3-24-4.5-42.5T120-715q0-66 47-113t113-47q36 0 57.5 9.5T379-845q20 11 42.5 20.5T480-815q36 0 58.5-9.5T581-845q20-11 42-20.5t57-9.5Zm0 80q-23 0-40.5 9.5T601-765q-21 11-49 20.5t-72 9.5q-44 0-72-9.5T359-765q-21-11-38.5-20.5T280-795q-33 0-56.5 23.5T200-715q0 8 1 23t4 35l55 405q1 8 7 12.5t14 4.5q5 0 9-2t6-6l101-148q14-20 36-32t47-12q25 0 47 12t36 32l103 151q2 3 5 4.5t7 1.5q8 0 14.5-4.5T700-251l55-406q3-20 4-35t1-23q0-33-23.5-56.5T680-795ZM480-515Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="content">
            <span class="title"> Klinika DentMax </span>
            <span class="description"> Twoje zęby nas pokochają! </span>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-semibold text-[#13293D] mb-6">Zaloguj się do swojego konta</h2>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Błąd:</strong> {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-[#13293D] font-medium">Email:</label>
                <input type="email" name="email" id="email"
                    class="w-full p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3]"
                    required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-[#13293D] font-medium">Hasło:</label>
                <input type="password" name="password" id="password"
                    class="w-full p-3 border border-[#2A628F] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5FA8D3]"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-[#13293D] text-white p-3 rounded-lg font-semibold hover:bg-[#16324F] transition duration-300">Zaloguj
                się</button>
        </form>

        <p class="mt-4 text-center">
            Nie masz konta? <a href="{{ route('register') }}" class="text-[#5FA8D3] hover:underline">Zarejestruj
                się</a>
        </p>
    </div>

</body>
</html>