<?php

namespace App\Tests\Infrastructure\ValueObject\Time;

use App\Infrastructure\Serialization\Json;
use App\Infrastructure\ValueObject\Time\SerializableTimezone;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SerializableTimezoneTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertEquals(
            SerializableTimezone::fromString('Europe/Brussels'),
            SerializableTimezone::default()
        );
    }

    public function testFromString(): void
    {
        $this->assertEquals(
            SerializableTimezone::fromString('Europe/Brussels'),
            new SerializableTimezone('Europe/Brussels')
        );
    }

    public function testItShouldThrowWhenEmpty(): void
    {
        $this->expectExceptionObject(new \RuntimeException('timezone cannot be empty'));
        SerializableTimezone::fromString(' ');
    }

    public function testFromOptionalString(): void
    {
        $this->assertNull(
            SerializableTimezone::fromOptionalString(''),
        );
    }

    public function testSerialize(): void
    {
        $timezone = SerializableTimezone::fromString('Europe/Brussels');
        $this->assertEquals(
            Json::encode($timezone),
            Json::encode((string) $timezone)
        );
    }

    #[DataProvider(methodName: 'provideOffsetInHoursData')]
    public function testGetOffsetInHours(SerializableTimezone $timezone, int $expectedOffset): void
    {
        $this->assertEquals(
            $expectedOffset,
            $timezone->getOffsetFromUtcInHours()
        );
    }

    public static function provideOffsetInHoursData(): array
    {
        return [
            [SerializableTimezone::UTC(), 0],
            [SerializableTimezone::default(), 1],
            [SerializableTimezone::fromString('America/New_York'), -5],
            [SerializableTimezone::fromString('Europe/Zagreb'), 1],
            [SerializableTimezone::fromString('Europe/Dublin'), 0],
            [SerializableTimezone::fromString('Australia/Melbourne'), 11],
        ];
    }
}
