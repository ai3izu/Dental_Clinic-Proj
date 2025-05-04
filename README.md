# Dental Clinic Management System

**Framework**: Laravel 12.X
**Styling**: Tailwind CSS  

## 📘 Opis projektu

System zarządzania przychodnią dentystyczną umożliwia skuteczne administrowanie danymi pacjentów, dentystów, wizyt oraz transakcji. Aplikacja jest przeznaczona zarówno dla pracowników przychodni, jak i dla pacjentów, wspierając m.in. proces rejestracji, umawiania wizyt, prowadzenia dokumentacji medycznej oraz zarządzania płatnościami.

## 🧩 Struktura bazy danych

Wszystkie pola i nazwy tabel zostały przetłumaczone na język angielski, zgodnie z wymaganiami projektu. Laravel automatycznie dodaje znaczniki czasu (`created_at`, `updated_at`) do każdego rekordu.

### Tabela: `users`

| Pole           | Typ danych | Opis |
|----------------|------------|------|
| id             | BIGINT (PK) | Unikalny identyfikator użytkownika |
| first_name     | VARCHAR    | Imię użytkownika |
| last_name      | VARCHAR    | Nazwisko użytkownika |
| email          | VARCHAR (UNIQUE) | Adres e-mail |
| password       | VARCHAR    | Zaszyfrowane hasło |
| role           | ENUM(admin, patient, doctor) | Rola użytkownika |
| created_at     | TIMESTAMP  | Data utworzenia |
| updated_at     | TIMESTAMP  | Data aktualizacji |

### Tabela: `patients`

| Pole           | Typ danych | Opis |
|----------------|------------|------|
| id             | BIGINT (PK) | Unikalny identyfikator pacjenta |
| user_id        | BIGINT (FK) | Powiązanie z użytkownikiem |
| phone_number   | VARCHAR    | Numer telefonu |
| postal_code    | VARCHAR    | Kod pocztowy |
| street         | VARCHAR    | Ulica |
| city           | VARCHAR    | Miasto |
| apartment_number   | VARCHAR    | Numer mieszkania |
| staircase_number  | VARCHAR    | Numer klatki |
| date_of_birth  | DATE       | Data urodzenia |
| created_at     | TIMESTAMP  | Data utworzenia |
| updated_at     | TIMESTAMP  | Data aktualizacji |

### Tabela: `dentists`

| Pole           | Typ danych | Opis |
|----------------|------------|------|
| id             | BIGINT (PK) | Unikalny identyfikator dentysty |
| user_id        | BIGINT (FK) | Powiązanie z użytkownikiem |
| specialization | VARCHAR    | Specjalizacja (np. ortodonta, higienista) |
| phone_number   | VARCHAR    | Numer telefonu |
| photo          | VARCHAR lub BLOB | Zdjęcie lekarza |
| reviews        | VARCHAR    | Opinie pacjentów |
| biography      | TEXT       | Opis kariery i doświadczenia |
| created_at     | TIMESTAMP  | Data utworzenia |
| updated_at     | TIMESTAMP  | Data aktualizacji |

### Tabela: `appointments`

| Pole           | Typ danych | Opis |
|----------------|------------|------|
| id             | BIGINT (PK) | Unikalny identyfikator wizyty |
| dentist_id     | BIGINT (FK) | Powiązanie z dentystą |
| patient_id     | BIGINT (FK) | Powiązanie z pacjentem |
| appointment_datetime | DATETIME | Data i godzina wizyty |
| status         | ENUM(scheduled, completed, cancelled) | Status wizyty |
| notes          | TEXT       | Opis wizyty |
| created_at     | TIMESTAMP  | Data utworzenia |
| updated_at     | TIMESTAMP  | Data aktualizacji |

### Tabela: `transactions`

| Pole           | Typ danych | Opis |
|----------------|------------|------|
| id             | BIGINT (PK) | Unikalny identyfikator transakcji |
| appointment_id | BIGINT (FK) | Powiązanie z wizytą |
| amount         | DECIMAL    | Kwota transakcji |
| payment_status | ENUM(paid, unpaid) | Status płatności |
| payment_date   | DATE       | Data płatności |
| created_at     | TIMESTAMP  | Data utworzenia |
| updated_at     | TIMESTAMP  | Data aktualizacji |

### Tabela: `reviews`

| Pole           | Typ danych | Opis |
|----------------|------------|------|
| dentist_id     | BIGINT (FK) | Powiązanie z dentystą |
| patient_id     | BIGINT (FK) | Powiązanie z pacjentem |
| content        | TEXT       | Treść recenzji |
| created_at     | TIMESTAMP  | Data utworzenia |
| updated_at     | TIMESTAMP  | Data aktualizacji |

## 🧠 Funkcjonalności

### Dla pacjenta:
- Rejestracja i logowanie do systemu
- Umawianie wizyt u dostępnych dentystów
- Przeglądanie historii wizyt
- Możliwość opłacenia wizyty online

### Dla dentysty:
- Podgląd zaplanowanych wizyt
- Potwierdzanie, anulowanie oraz dodawanie opisów wizyt

### Dla administratora:
- Pełne zarządzanie użytkownikami (CRUD)
- Zarządzanie kontami dentystów (CRUD)
- Generowanie raportów z wizyt, transakcji i dostępności dentystów

## 🔗 Relacje w bazie danych

- **Users ↔ Patients** – relacja 1:1
- **Users ↔ Dentists** – relacja 1:1
- **Patients ↔ Appointments** – relacja 1:N
- **Dentists ↔ Appointments** – relacja 1:N
- **Appointments ↔ Transactions** – relacja 1:1
- **Patients ↔ Reviews ↔ Dentists** – relacja N:M (pośrednio)

## 📑 Dokumentacja projektu 

Dokumentacja projektu znajduje się w katalogu `docs`

