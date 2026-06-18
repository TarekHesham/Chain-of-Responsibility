<?php

namespace App\Entities;

use App\Enums\CategoryEnum;
use App\Enums\StatusEnum;
use App\Enums\TicketPriorityEnum;

class Ticket
{
    public function __construct(
        public string $id,
        public string $customerName,
        public TicketPriorityEnum $priority,
        public CategoryEnum $category,
        public string $description,
        public StatusEnum $status = StatusEnum::PENDING,
        // Optional requirments
        public array $logs = [],
        public int $hops = 0,
    ) {}
}
