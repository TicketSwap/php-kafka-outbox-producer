<?php

declare(strict_types=1);

namespace TicketSwap\Kafka\Outbox\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TicketSwap\Kafka\Outbox\Entity\OutboxMessage;

/**
 * @extends ServiceEntityRepository<OutboxMessage>
 */
class DoctrineOutboxMessageRepository extends ServiceEntityRepository implements OutboxMessageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutboxMessage::class);
    }

    public function save(OutboxMessage ...$outboxMessages) : void
    {
        foreach ($outboxMessages as $outboxMessage) {
            $this->_em->persist($outboxMessage);
        }

        $this->_em->flush();
    }
}
