<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class OutboxMessageTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_possible_to_create_a_new_instance() : void
    {
        $time = new DateTimeImmutable('2021-04-12 13:37:42');

        $id      = Uuid::uuid4();
        $message = new OutboxMessage(
            $id,
            'event.foo.bar',
            '148',
            $time,
            'foo bar');

        $this->assertEquals($id->toString(), $message->getId());
        $this->assertEquals('event.foo.bar', $message->getTopic());
        $this->assertEquals('148', $message->getPartitionKey());
        $this->assertEquals('1618234662000', $message->getTimestamp());
        $this->assertEquals('foo bar', $message->getMessage());
        $this->assertFalse($message->isProcessed());
    }
}
