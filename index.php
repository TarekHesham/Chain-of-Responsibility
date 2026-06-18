<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Handlers\BasicSupportHandler;
use App\Handlers\TechnicalSupportHandler;
use App\Handlers\EngineeringHandler;
use App\Handlers\ManagementHandler;
use App\Entities\Ticket;
use App\Enums\TicketPriorityEnum;
use App\Enums\CategoryEnum;

$basic       = new BasicSupportHandler();
$technical   = new TechnicalSupportHandler();
$engineering = new EngineeringHandler();
$management  = new ManagementHandler();

$basic
    ->setNext($technical)
    ->setNext($engineering)
    ->setNext($management);

$tickets = [
    new Ticket("T001", "Ahmed", TicketPriorityEnum::LOW, CategoryEnum::ACCOUNT, "Forgot password"),
    new Ticket("T002", "Hamada", TicketPriorityEnum::HIGH, CategoryEnum::BUG, "App crashes on login"),
    new Ticket("T003", "Mohamed", TicketPriorityEnum::CRITICAL, CategoryEnum::BUSINESS, "VIP client data breach"),
    new Ticket("T004", "Tarek", TicketPriorityEnum::MEDIUM, CategoryEnum::BUSINESS, "Invoice question"),
    new Ticket("T005", "Mariam", TicketPriorityEnum::MEDIUM, CategoryEnum::TECHNICAL, "API returns 404")
];

foreach ($tickets as $ticket) {
    echo PHP_EOL . "=== Processing Ticket: {$ticket->id} ===" . PHP_EOL;
    $basic->handle($ticket);

    echo PHP_EOL . "Audit Trail:" . PHP_EOL;
    foreach ($ticket->logs as $log) {
        echo "  - {$log}" . PHP_EOL;
    }
}

echo PHP_EOL . "--- Resolved Counts ---" . PHP_EOL;
echo "Basic: " . $basic->getProcessedCount() . PHP_EOL;
echo "Technical: " . $technical->getProcessedCount() . PHP_EOL;
echo "Engineering: " . $engineering->getProcessedCount() . PHP_EOL;
echo "Management: " . $management->getProcessedCount() . PHP_EOL;
