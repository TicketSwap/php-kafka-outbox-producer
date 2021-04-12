<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Clock;

use DateTimeImmutable;

final class RealSystemClock implements SystemClock
{
    public function now() : DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
