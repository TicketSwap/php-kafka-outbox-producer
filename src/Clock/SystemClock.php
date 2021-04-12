<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Clock;

use DateTimeImmutable;

interface SystemClock
{
    public function now() : DateTimeImmutable;
}
