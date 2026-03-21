<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Services\LogService;

class TicketObserver
{
    public function created(Ticket $ticket): void
    {
        LogService::logCreate($ticket, null, 'Utworzono nowy ticket');
    }

    public function updated(Ticket $ticket): void
    {
        if ($ticket->isDirty()) {
            LogService::logUpdate($ticket, $ticket->getDirty(), null, 'Zaktualizowano ticket');
        }
    }

    public function deleted(Ticket $ticket): void
    {
        LogService::logDelete($ticket, null, 'Usunięto ticket');
    }
}
