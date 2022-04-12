<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PreUpdate;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;

#[Table(name: "outbox_message", options: ["charset" => "utf8mb4", "collation" => "utf8mb4_unicode_ci"])]
#[Index(columns: ["processed", "timestamp"], name: "processed")]
#[Entity]
#[HasLifecycleCallbacks]
class OutboxMessage
{
    #[Column(name: "id", type: "string", length: 36)]
    #[Id]
    private string $id;

    #[Column(name: "topic", type: "string")]
    private string $topic;

    #[Column(name: "partition_key", type: "string")]
    private string $partitionKey;

    #[Column(name: "timestamp", type: "bigint")]
    private string $timestamp;

    #[Column(name: "message", type: "text")]
    private string $message;

    #[Column(name: "processed", type: "boolean")]
    private bool $processed;

    #[Column(name: "created_at", type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    #[Column(name: "updated_at", type: "datetime_immutable", nullable: true)]
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

    #[PreUpdate]
    public function updateTimestamp() : void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
