@echo off
cd /d %~dp0

set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe
set DB_NAME=fishing_club
set DB_USER=root
set DB_PASS=

echo Tworzenie bazy danych…
"%MYSQL_PATH%" -u %DB_USER% --password=%DB_PASS% -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" || goto :error

echo Instalacja zależności PHP…
call composer install --no-interaction --optimize-autoloader

echo Instalacja zależności frontendowych…
call npm install

REM Tworzenie .env, jeśli nie istnieje
if not exist .env (
    echo Tworzenie pliku .env...
    (
        echo APP_NAME=Laravel
        echo APP_ENV=local
        echo APP_KEY=
        echo APP_DEBUG=true
        echo APP_URL=http://localhost

        echo APP_LOCALE=pl
        echo APP_FALLBACK_LOCALE=pl
        echo APP_FAKER_LOCALE=en_US

        echo APP_MAINTENANCE_DRIVER=file

        echo PHP_CLI_SERVER_WORKERS=4
        echo BCRYPT_ROUNDS=12

        echo LOG_CHANNEL=stack
        echo LOG_STACK=single
        echo LOG_DEPRECATIONS_CHANNEL=null
        echo LOG_LEVEL=debug

        echo DB_CONNECTION=mysql
        echo DB_HOST=127.0.0.1
        echo DB_PORT=3306
        echo DB_DATABASE=dental_clinic
        echo DB_USERNAME=root
        echo DB_PASSWORD=

        echo SESSION_DRIVER=database
        echo SESSION_LIFETIME=120
        echo SESSION_ENCRYPT=false
        echo SESSION_PATH=/
        echo SESSION_DOMAIN=null

        echo BROADCAST_CONNECTION=log
        echo FILESYSTEM_DISK=local
        echo QUEUE_CONNECTION=sync
        
        echo CACHE_STORE=database

        echo MEMCACHED_HOST=127.0.0.1

        echo REDIS_CLIENT=phpredis
        echo REDIS_HOST=127.0.0.1
        echo REDIS_PASSWORD=null
        echo REDIS_PORT=6379

        echo MAIL_MAILER=log
        echo MAIL_SCHEME=null
        echo MAIL_HOST=127.0.0.1
        echo MAIL_PORT=2525
        echo MAIL_USERNAME=null
        echo MAIL_PASSWORD=null
        echo MAIL_FROM_ADDRESS="hello@example.com"
        echo MAIL_FROM_NAME="${APP_NAME}"

        echo AWS_ACCESS_KEY_ID=
        echo AWS_SECRET_ACCESS_KEY=
        echo AWS_DEFAULT_REGION=us-east-1
        echo AWS_BUCKET=
        echo AWS_USE_PATH_STYLE_ENDPOINT=false

        echo VITE_APP_NAME="${APP_NAME}"
    ) > .env
) else (
    echo Plik .env istnieje, pomijam tworzenie.
)

echo Generowanie klucza aplikacji…
call php artisan key:generate --ansi

echo Tworzenie symlinku storage…
call php artisan storage:link

echo Odświeżanie bazy i seedowanie danych…
call php artisan migrate:fresh --seed --force

echo Budowanie frontendu...
call npm run build

echo Uruchamianie watch/frontend dev…
start "" npm run dev

echo Uruchamianie wbudowanego serwera PHP…
start "Laravel Server" php artisan serve --host=127.0.0.1 --port=8000

echo.
echo Wszystkie procesy wystartowane pomyślnie.
pause
exit /b 0

:error
echo.
echo Nie udało się wykonać kroku tworzenia bazy danych.
pause
exit /b 1
