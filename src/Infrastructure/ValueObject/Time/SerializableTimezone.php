<?php

declare(strict_types=1);

namespace App\Infrastructure\ValueObject\Time;

class SerializableTimezone extends \DateTimeZone implements \JsonSerializable, \Stringable
{
    public static function default(): self
    {
        return self::fromString('Europe/Brussels');
    }

    public static function UTC(): self
    {
        return self::fromString('UTC');
    }

    public static function fromString(string $string): self
    {
        if (empty(trim($string))) {
            throw new \RuntimeException('timezone cannot be empty');
        }

        return new self($string);
    }

    public static function fromOptionalString(?string $string = null): ?self
    {
        return $string ? self::fromString($string) : null;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function jsonSerialize(): string
    {
        return $this->getName();
    }

    public function getOffsetFromUtcInHours(): int
    {
        return (int) round(SerializableDateTime::fromString('2024-01-01 00:00:00', $this)->getOffset() / 3600);
    }
}
