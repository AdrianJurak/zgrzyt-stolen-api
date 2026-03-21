# ZGRZYT – Zgłoszenia i Rejestr Zdarzeń Technicznych

# WERSJA ALFA !!!#
# Do poprawy:
    - optymalizacja endpointów
    - dodanie obsługi poczty email
    - dodanie dwuetapowej weryfikacji dla admina oraz ograniczenie możliwości serwerowych w panelu
    - dodanie testów !!!
    
## Opis Aplikacji
**ZGRZYT** to webowa aplikacja do zgłaszania, obsługi i monitorowania błędów w systemach informatycznych. Projekt oparty jest na architekturze oddzielonego backendu i frontendu.

Aplikacja umożliwia:
- Zgłaszanie błędów przez użytkowników.
- Obsługę zgłoszeń przez dział IT.
- Komunikację w obrębie zgłoszenia (prosty komunikator).
- Automatyczne powiadomienia e-mail o zmianie statusu zgłoszenia.

## Technologie

### Backend (API)
- **Framework:** Laravel 12 (PHP 8.3)
- **Komunikacja:** REST API (JSON)
- **Zadania:** Logika biznesowa, obsługa bazy danych, autoryzacja (tokeny, role).


### Baza Danych i Infrastruktura
- **Baza:** SQL (MySQL / Azure SQL)
- **Hosting:** Azure App Service

## Struktura Bazy Danych

System opiera się na czterech głównych tabelach:

1.  **users** – Użytkownicy systemu (role: `user`, `it`, `admin`).
2.  **tickets** – Zgłoszenia (tytuł, opis, status, priorytet, relacje do użytkowników).
3.  **messages** – Wiadomości w ramach zgłoszenia (komunikator użytkownik ↔ IT).
4.  **logs** – Logi systemowe (historia akcji użytkowników, np. zmiany statusów, logowania).

### Relacje
- Jeden użytkownik -> Wiele zgłoszeń.
- Jedno zgłoszenie -> Jeden przypisany pracownik IT.
- Jedno zgłoszenie -> Wiele wiadomości.

## Plan Rozwoju (Roadmap)

1.  **Analiza:** Definicja funkcji i ról.
2.  **Baza danych:** Projekt ERD i relacji.
3.  **Backend:** Implementacja API w Laravel.
4.  **Frontend:** Implementacja interfejsu w Vue.js.
5.  **Testy:** Weryfikacja poprawności działania.
6.  **Wdrożenie:** Publikacja na Azure App Service.

## Zalety
- Czytelna architektura (Separation of Concerns).
- Skalowalność i bezpieczny dostęp do danych.
- Gotowość pod wdrożenie chmurowe.

---
*Projekt edukacyjny / studencki.*