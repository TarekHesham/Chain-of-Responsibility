<p align="center">
    <a href="https://refactoring.guru/design-patterns/chain-of-responsibility" target="_blank">
        <img src="https://refactoring.guru/images/patterns/content/chain-of-responsibility/chain-of-responsibility-1.5x.png" width="500" alt="Chain of Responsibility Pattern">
    </a>
</p>

# Chain of Responsibility Pattern - Support Ticket System

This repository demonstrates an educational implementation of the Chain of Responsibility Design Pattern using pure PHP as part of an annual software engineering mentorship program.

The example simulates a **Customer Support Ticket System** where support requests are routed through multiple support levels until the appropriate handler processes the ticket.

The project focuses on clean architecture, extensibility, and practical pattern implementation rather than framework-specific features.

---

## Problem

A SaaS company receives different types of support tickets:

* Account issues
* Technical problems
* Software bugs
* Business requests
* Critical escalations

Different teams are responsible for different categories and priorities.

Without the Chain of Responsibility pattern, the client code quickly becomes filled with nested `if/else` statements and tightly coupled routing logic.

The **Chain of Responsibility Pattern** solves this by allowing each handler to:

1. Decide whether it can process the request.
2. Process the request if applicable.
3. Pass the request to the next handler otherwise.

This keeps the sender completely decoupled from the actual receiver.

---

## Implemented Support Levels

### Level 1 - Basic Support

Handles:

* LOW priority tickets
* ACCOUNT category tickets

Examples:

* Forgot password
* Account access issues

---

### Level 2 - Technical Support

Handles:

* LOW or MEDIUM priority
* TECHNICAL or BUG categories

Examples:

* API errors
* Integration issues

---

### Level 3 - Engineering

Handles:

* HIGH priority
* TECHNICAL or BUG categories

Examples:

* Application crashes
* Database failures

---

### Level 4 - Management

Handles:

* CRITICAL tickets
* Business escalations

Examples:

* VIP customer incidents
* Legal issues
* Data breaches

---

> **Note**
>
> This repository was created as part of an annual software engineering mentorship program and serves as an educational implementation of the **Chain of Responsibility Design Pattern**.
>
> The goal is to demonstrate the pattern, object-oriented design principles, and extensibility techniques in a simple and understandable way.
>
> It is **not intended to be a production-ready support ticket system**.
>
> Several features such as audit logging, priority boosting, circular chain detection, and handler statistics were intentionally added as learning exercises to explore how the pattern can evolve in real-world scenarios.

---

## Features

### Chain of Responsibility

Requests flow through a configurable chain of handlers:

```php
$basic
    ->setNext($technical)
    ->setNext($engineering)
    ->setNext($management);
```

---

### Audit Trail

Each ticket records every step performed during processing.

Example:

```text
Audit Trail:
  - BasicSupport checked ticket
  - BasicSupport cannot handle ticket
  - TechnicalSupport checked ticket
  - TechnicalSupport resolved ticket
```

---

### Handler Statistics

Each handler tracks how many tickets it successfully processed.

Example:

```text
--- Resolved Counts ---
Basic: 1
Technical: 1
Engineering: 1
Management: 1
```

---

### Circular Chain Protection

The implementation prevents accidentally creating circular chains.

```php
$handlerA->setNext($handlerB);
$handlerB->setNext($handlerA); // Exception
```

---

### Priority Boosting

If a ticket passes through multiple handlers without being resolved, its priority can automatically be increased.

Example:

```text
Priority boosted from LOW to MEDIUM
```

---

## Project Structure

```text
App
├── Entities
│   └── Ticket.php
│
├── Enums
│   ├── CategoryEnum.php
│   ├── StatusEnum.php
│   └── TicketPriorityEnum.php
│
└── Handlers
    ├── SupportHandler.php
    ├── BasicSupportHandler.php
    ├── TechnicalSupportHandler.php
    ├── EngineeringHandler.php
    └── ManagementHandler.php
```

---

## Ticket Structure

```php
Ticket(
    id,
    customerName,
    priority,
    category,
    description,
    status,
    logs,
    hops
)
```

---

## Run Example

Generate Composer autoload files:

```bash
composer dump-autoload
```

Run the project:

```bash
php index.php
```

---

## Example Output

```text
=== Processing Ticket: T002 ===

[BasicSupport] Cannot handle T002, passing to next...
[TechnicalSupport] Cannot handle T002, passing to next...
[Engineering] Handling ticket T002: App crashes on login -> RESOLVED

Audit Trail:
  - BasicSupport checked ticket
  - BasicSupport cannot handle ticket
  - TechnicalSupport checked ticket
  - TechnicalSupport cannot handle ticket
  - Engineering checked ticket
  - Engineering resolved ticket
```

---

## Design Principles Demonstrated

* Chain of Responsibility Pattern
* Open/Closed Principle
* Single Responsibility Principle
* Loose Coupling
* Runtime Chain Configuration
* Extensible Request Processing Pipelines

---

## Educational Objectives

This project was built to practice and demonstrate:

- Chain of Responsibility Pattern
- Object-Oriented Design
- SOLID Principles
- Request Routing
- Extensible Architectures
- Runtime Chain Configuration

The implementation intentionally includes additional learning-oriented features such as audit trails, handler statistics, priority boosting, and circular chain detection to explore common design challenges beyond the basic pattern requirements.

---

## Reference

https://refactoring.guru/design-patterns/chain-of-responsibility
