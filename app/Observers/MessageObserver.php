<?php

namespace App\Observers;

use App\Models\Message;
use App\Services\LogService;

class MessageObserver
{
    public function created(Message $message): void
    {
        LogService::logCreate($message, null, 'Utworzono nową wiadomość');
    }

    public function updated(Message $message): void
    {
        if ($message->isDirty()) {
            LogService::logUpdate($message, $message->getDirty(), null, 'Zaktualizowano wiadomość');
        }
    }

    public function deleted(Message $message): void
    {
        LogService::logDelete($message, null, 'Usunięto wiadomość');
    }
}
