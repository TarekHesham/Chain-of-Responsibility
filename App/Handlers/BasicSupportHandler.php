<?php

namespace App\Handlers;

use App\Enums\CategoryEnum;
use App\Enums\StatusEnum;
use App\Enums\TicketPriorityEnum;
use App\Entities\Ticket;

class BasicSupportHandler extends SupportHandler
{
    protected function canHandle(Ticket $ticket): bool
    {
        return
            $ticket->priority === TicketPriorityEnum::LOW
            || $ticket->category === CategoryEnum::ACCOUNT;
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = StatusEnum::RESOLVED;

        echo "[BasicSupport] Handling ticket {$ticket->id}: {$ticket->description} -> Status: RESOLVED" . PHP_EOL;
    }
}
