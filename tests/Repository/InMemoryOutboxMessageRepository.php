<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Repository;

use TicketSwap\Kafka\Outbox\Entity\OutboxMessage;

final class InMemoryOutboxMessageRepository implements OutboxMessageRepository
{
    /**
     * @var OutboxMessage[]
     */
    private $data = [];

    public function save(OutboxMessage ...$outboxMessages) : void
    {
        foreach ($outboxMessages as $kafkaMessage) {
            $this->data[$kafkaMessage->getId()] = $kafkaMessage;
        }
    }

    public function getSize() : int
    {
        return count($this->data);
    }

    public function shift() : ?OutboxMessage
    {
        return array_shift($this->data);
    }
}
