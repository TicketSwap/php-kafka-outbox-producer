<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Producer;

use Ramsey\Uuid\Uuid;
use TicketSwap\Kafka\Outbox\Clock\SystemClock;
use TicketSwap\Kafka\Outbox\Entity\OutboxMessage;
use TicketSwap\Kafka\Outbox\Repository\OutboxMessageRepository;

final class OutboxProducer implements Producer
{
    private OutboxMessageRepository $outboxMessageRepository;

    private SystemClock $clock;

    public function __construct(OutboxMessageRepository $outboxMessageRepository, SystemClock $clock)
    {
        $this->outboxMessageRepository = $outboxMessageRepository;
        $this->clock                   = $clock;
    }

    public function produce(string $topic, string $key, string $message) : void
    {
        $message = new OutboxMessage(
            Uuid::uuid4(),
            $topic,
            $key,
            $this->clock->now(),
            $message,
        );

        $this->outboxMessageRepository->save($message);
    }
}
