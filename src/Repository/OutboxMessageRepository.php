<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Repository;

use TicketSwap\Kafka\Outbox\Entity\OutboxMessage;

interface OutboxMessageRepository
{
    public function save(OutboxMessage ...$outboxMessages) : void;
}
