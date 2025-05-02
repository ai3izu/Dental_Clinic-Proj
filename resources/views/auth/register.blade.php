<!DOCTYPE html>
<html>

<head>
    <title>Rejestracja</title>
</head>

<body>
    <h2>Rejestracja pacjenta</h2>

    @if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div>
            <label>Imię:</label>
            <input type="text" name="first_name" required>
        </div>

        <div>
            <label>Nazwisko:</label>
            <input type="text" name="last_name" required>
        </div>
        
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Hasło:</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Potwierdź hasło:</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Zarejestruj się</button>
    </form>

    <p>Masz już konto? <a href="{{ route('login') }}">Zaloguj się</a></p>
</body>

</html>