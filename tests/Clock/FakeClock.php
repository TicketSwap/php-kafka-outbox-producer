<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Clock;

use DateTimeImmutable;

final class FakeClock implements SystemClock
{
    private DateTimeImmutable $currentTime;

    public function __construct(DateTimeImmutable $currentTime)
    {
        $this->currentTime = $currentTime;
    }

    public function now() : DateTimeImmutable
    {
        return $this->currentTime;
    }
}
