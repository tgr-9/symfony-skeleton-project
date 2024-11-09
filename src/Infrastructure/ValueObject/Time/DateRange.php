<?php

declare(strict_types=1);

namespace App\Infrastructure\ValueObject\Time;

final readonly class DateRange
{
    private function __construct(
        private SerializableDateTime $from,
        private SerializableDateTime $till)
    {
        if ($from > $till) {
            throw new \InvalidArgumentException('invalid DateRange: '.$from.' till '.$till);
        }
    }

    public static function fromDates(SerializableDateTime $from, SerializableDateTime $till): self
    {
        return new self($from, $till);
    }

    public function getFrom(): SerializableDateTime
    {
        return $this->from;
    }

    public function getTill(): SerializableDateTime
    {
        return $this->till;
    }
}
