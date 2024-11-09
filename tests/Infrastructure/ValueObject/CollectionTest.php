<?php

namespace App\Infrastructure\ValueObject;

use App\Infrastructure\ValueObject\String\Name;
use App\Tests\Infrastructure\ValueObject\ATestCollection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testEmpty(): void
    {
        $this->assertEquals(
            ATestCollection::empty(),
            ATestCollection::fromArray([])
        );
        $this->assertTrue(ATestCollection::empty()->isEmpty());
    }

    public function testHas(): void
    {
        $collection = ATestCollection::empty()
            ->add(Name::fromString(10));

        $this->assertTrue(
            $collection->has(Name::fromString(10))
        );
        $this->assertFalse(
            $collection->has(Name::fromString(20))
        );
    }

    public function testMergeWith(): void
    {
        $collection = ATestCollection::empty()
            ->add(Name::fromString(10))
            ->mergeWith(ATestCollection::fromArray([Name::fromString(20)]));

        $this->assertEqualsCanonicalizing(
            $collection,
            ATestCollection::fromArray([Name::fromString(10), Name::fromString(20)])
        );

        $this->assertEqualsCanonicalizing(
            $collection,
            ATestCollection::fromArray([Name::fromString(20), Name::fromString(10)])
        );
    }

    public function testItShouldGuardCollectionItemType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Item must be an instance of App\Infrastructure\ValueObject\String\Name');

        ATestCollection::empty()->add('wrong');
    }
}
