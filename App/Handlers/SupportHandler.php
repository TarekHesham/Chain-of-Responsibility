<?php

namespace App\Handlers;

use App\Entities\Ticket;
use App\Enums\StatusEnum;
use App\Enums\TicketPriorityEnum;
use RuntimeException;

abstract class SupportHandler
{
    protected ?SupportHandler $next = null;
    protected int $processedCount = 0;

    public function setNext(SupportHandler $handler): SupportHandler
    {
        $current = $handler;

        while ($current !== null) {
            if ($current === $this) {
                throw new RuntimeException(
                    'Circular chain detected'
                );
            }

            $current = $current->next;
        }

        $this->next = $handler;

        return $handler;
    }

    public function handle(Ticket $ticket): void
    {
        $name = $this->handlerName();

        $ticket->logs[] = $name . " checked ticket";

        if ($this->canHandle($ticket)) {
            $ticket->status = StatusEnum::IN_PROGRESS;

            $this->process($ticket);

            if ($ticket->status === StatusEnum::ESCALATED) {
                $ticket->logs[] = $name . " escalated ticket";
            } else {
                $ticket->logs[] = $name . " resolved ticket";
            }

            $this->processedCount++;
            return;
        }

        $ticket->logs[] = $name . " cannot handle ticket";

        // Priority boosting
        $ticket->hops++;

        if (
            $ticket->hops >= 3
            && $ticket->priority === TicketPriorityEnum::LOW
        ) {
            $ticket->priority = TicketPriorityEnum::MEDIUM;
            $ticket->logs[] = "Priority boosted from LOW to MEDIUM";
        }

        echo "[" . $name . "] Cannot handle {$ticket->id}, passing to next..." . PHP_EOL;

        if ($this->next) {
            $this->next->handle($ticket);

            return;
        }

        $ticket->status = StatusEnum::ESCALATED;

        echo "Ticket {$ticket->id} reached end of chain unhandled -> Status: ESCALATED" . PHP_EOL;
    }

    public function getProcessedCount(): int
    {
        return $this->processedCount;
    }

    abstract protected function canHandle(Ticket $ticket): bool;

    abstract protected function process(Ticket $ticket): void;

    private function handlerName(): string
    {
        return str_replace("Handler", "", (new \ReflectionClass($this))->getShortName());
    }
}
