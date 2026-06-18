<?php

namespace App\Handlers;

use App\Entities\Ticket;
use App\Enums\StatusEnum;
use App\Enums\TicketPriorityEnum;

class ManagementHandler extends SupportHandler
{
    protected function canHandle(Ticket $ticket): bool
    {
        return $ticket->priority === TicketPriorityEnum::CRITICAL;
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = StatusEnum::ESCALATED;

        echo "[Management] Handling {$ticket->priority->name} ticket {$ticket->id}: {$ticket->description} -> Status: ESCALATED" . PHP_EOL;
    }
}
