<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>

    @if($errors->any())
        <div style="color: red;">
            <strong>Błąd:</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Hasło:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Zaloguj się</button>
    </form>

    <p>Nie masz konta? <a href="{{ route('register') }}">Zarejestruj się</a></p>
</body>
</html>
