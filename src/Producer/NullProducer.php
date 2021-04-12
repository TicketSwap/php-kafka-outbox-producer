<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Producer;

final class NullProducer implements Producer
{
    public function produce(string $topic, string $key, string $message) : void
    {
    }
}
