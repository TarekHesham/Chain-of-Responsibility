<?php

namespace App\Handlers;

use App\Entities\Ticket;
use App\Enums\StatusEnum;
use App\Enums\TicketPriorityEnum;
use App\Enums\CategoryEnum;

class TechnicalSupportHandler extends SupportHandler
{
    protected function canHandle(Ticket $ticket): bool
    {
        return
            in_array(
                $ticket->priority,
                [
                    TicketPriorityEnum::LOW,
                    TicketPriorityEnum::MEDIUM
                ]
            )
            &&
            in_array(
                $ticket->category,
                [
                    CategoryEnum::TECHNICAL,
                    CategoryEnum::BUG
                ]
            );
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = StatusEnum::RESOLVED;

        echo "[TechnicalSupport] Handling ticket {$ticket->id}: {$ticket->description} -> RESOLVED" . PHP_EOL;
    }
}
