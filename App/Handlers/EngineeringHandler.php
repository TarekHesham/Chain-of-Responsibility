<?php

namespace App\Handlers;

use App\Enums\CategoryEnum;
use App\Enums\StatusEnum;
use App\Enums\TicketPriorityEnum;
use App\Entities\Ticket;

class EngineeringHandler extends SupportHandler
{
    protected function canHandle(Ticket $ticket): bool
    {
        return
            $ticket->priority === TicketPriorityEnum::HIGH
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

        echo "[Engineering] Handling ticket {$ticket->id}: {$ticket->description} -> RESOLVED" . PHP_EOL;
    }
}
