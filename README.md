# php-kafka-outbox-producer

PHP library to produce Kafka messages using the outbox pattern

## Installation

Open a command console, enter your project directory and execute:

```console
$ composer require ticketswap/kafka-outbox-producer
```

After that, add the bundle to your kernel:

```php
// config/bundles.php
return [
    // ...
    TicketSwap\Kafka\Outbox\Bundle\TicketSwapKafkaOutboxBundle::class => ['all' => true],
];
```
