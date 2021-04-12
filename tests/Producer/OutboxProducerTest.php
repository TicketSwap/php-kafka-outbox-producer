<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Producer;

use PHPUnit\Framework\TestCase;
use TicketSwap\Kafka\Outbox\Clock\FakeClock;
use TicketSwap\Kafka\Outbox\Clock\SystemClock;
use TicketSwap\Kafka\Outbox\Repository\InMemoryOutboxMessageRepository;

final class OutboxProducerTest extends TestCase
{
    private OutboxProducer $outboxProducer;

    private InMemoryOutboxMessageRepository $kafkaMessageRepository;

    private SystemClock $clock;

    public function setUp() : void
    {
        $this->kafkaMessageRepository = new InMemoryOutboxMessageRepository();
        $this->clock                  = new FakeClock(new \DateTimeImmutable('2021-04-12 13:37:42'));

        $this->outboxProducer = new OutboxProducer($this->kafkaMessageRepository, $this->clock);
    }

    /**
     * @test
     */
    public function it_should_store_a_record_in_the_database() : void
    {
        // Arrange
        $topic     = 'event.foo.bar';
        $key       = '148';
        $message   = 'foo bar';
        $timestamp = '1618234662000';

        // Act
        $this->outboxProducer->produce($topic, $key, $message);

        // Assert
        self::assertEquals(1, $this->kafkaMessageRepository->getSize());

        $lastKafkaMessage = $this->kafkaMessageRepository->shift();
        self::assertNotNull($lastKafkaMessage);
        self::assertEquals($topic, $lastKafkaMessage->getTopic());
        self::assertEquals($key, $lastKafkaMessage->getPartitionKey());
        self::assertEquals($timestamp, $lastKafkaMessage->getTimestamp());
        self::assertEquals($message, $lastKafkaMessage->getMessage());
    }
}
