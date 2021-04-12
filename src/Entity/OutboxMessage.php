<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="outbox_message", indexes={
 *     @ORM\Index(name="processed", columns={"processed", "timestamp"})
 * }, options={"charset": "utf8mb4", "collate": "utf8mb4_unicode_ci"})
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class OutboxMessage
{
    /**
     * @ORM\Column(name="id", type="string", length=36, options={"collation": "utf8mb4_unicode_ci"})
     * @ORM\Id
     */
    private string $id;

    /**
     * @ORM\Column(name="topic", type="string")
     */
    private string $topic;

    /**
     * @ORM\Column(name="partition_key", type="string")
     */
    private string $partitionKey;

    /**
     * @ORM\Column(name="timestamp", type="bigint")
     */
    private string $timestamp;

    /**
     * @ORM\Column(name="message", type="text")
     */
    private string $message;

    /**
     * @ORM\Column(name="processed", type="boolean")
     */
    private bool $processed;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct(
        UuidInterface $id,
        string $topic,
        string $partitionKey,
        DateTimeImmutable $time,
        string $message
    ) {
        $this->id           = $id->toString();
        $this->topic        = $topic;
        $this->partitionKey = $partitionKey;
        $this->timestamp    = (string) $this->getMillisecondTimestamp($time); // Creates a unix timestamp in milliseconds
        $this->message      = $message;
        $this->processed    = false;
        $this->createdAt    = $time;
        $this->updatedAt    = $time;
    }

    /**
     * Returns a timestamp rounded with millisecond precision
     *
     * @param DateTimeImmutable $time
     * @return float
     */
    private function getMillisecondTimestamp(DateTimeImmutable $time) : float
    {
        return round($time->format('Uu') / pow(10, 3));
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getTopic() : string
    {
        return $this->topic;
    }

    public function getPartitionKey() : string
    {
        return $this->partitionKey;
    }

    public function getTimestamp() : string
    {
        return $this->timestamp;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function isProcessed() : bool
    {
        return $this->processed;
    }

    public function getCreatedAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt() : ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateTimestamp() : void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
