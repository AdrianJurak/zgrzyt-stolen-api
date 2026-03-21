<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Użytkownik Admin
        $admin = User::create([
            'name' => 'Administrator',
            'login' => 'admin',
            'email' => 'admin@zgrzyt.pl',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'active' => true,
        ]);

        // Pracownik IT
        $itUser = User::create([
            'name' => 'Pracownik IT',
            'login' => 'it',
            'email' => 'it@zgrzyt.pl',
            'password' => Hash::make('password'),
            'role' => 'it',
            'active' => true,
        ]);

        // Zwykły Użytkownik
        $user = User::create([
            'name' => 'Użytkownik',
            'login' => 'user',
            'email' => 'user@zgrzyt.pl',
            'password' => Hash::make('password'),
            'role' => 'user',
            'active' => true,
        ]);

        // Przykładowe zgłoszenia

        // Zgłoszenie 1 (Nowe)
        Ticket::create([
            'title' => 'Problem z drukarką',
            'description' => 'Drukarka w pokoju 202 nie drukuje. Świeci się czerwona lampka.',
            'status' => 'nowe',
            'priority' => 'średni',
            'user_id' => $user->id,
        ]);

        // Zgłoszenie 2 (W trakcie)
        $ticket2 = Ticket::create([
            'title' => 'Brak dostępu do folderu sieciowego',
            'description' => 'Nie mogę otworzyć folderu \\\\fileserver\\share. Wyskakuje błąd \'Odmowa dostępu\'.',
            'status' => 'w trakcie',
            'priority' => 'wysoki',
            'user_id' => $user->id,
            'assigned_it_id' => $itUser->id,
        ]);

        $ticket2->messages()->create([
            'message' => 'Przyjąłem zgłoszenie, sprawdzam uprawnienia.',
            'sender_id' => $itUser->id,
        ]);

        // Zgłoszenie 3 (Zamknięte)
        $ticket3 = Ticket::create([
            'title' => 'Myszka przestała działać',
            'description' => 'Moja myszka nie reaguje. Próbowałem przepiąć do innego portu USB, ale bez zmian.',
            'status' => 'zamknięte',
            'priority' => 'niski',
            'user_id' => $user->id,
            'assigned_it_id' => $itUser->id,
        ]);

        $ticket3->messages()->createMany([
            ['message' => 'Proszę sprawdzić, czy myszka działa na innym komputerze.', 'sender_id' => $itUser->id],
            ['message' => 'Na laptopie kolegi działa.', 'sender_id' => $user->id],
            ['message' => 'Ok, wygląda na problem ze stacją. Będę za 15 minut z nową myszką do testów.', 'sender_id' => $itUser->id],
            ['message' => 'Myszka wymieniona, zamykam zgłoszenie.', 'sender_id' => $itUser->id]
        ]);

        // Zgłoszenie 4 (Nowe, od Admina)
        Ticket::create([
            'title' => 'Potrzebny dostęp do systemu CRM dla nowego pracownika',
            'description' => 'Proszę o utworzenie konta w systemie CRM dla Anny Nowak (anna.nowak@example.com).',
            'status' => 'nowe',
            'priority' => 'średni',
            'user_id' => $admin->id,
            'assigned_it_id' => $itUser->id,
        ]);
    }
}
