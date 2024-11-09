<?php

declare(strict_types=1);

namespace App\Infrastructure\CQRS\Bus;

abstract class DomainCommand implements Command
{
    /**
     * @return array{commandName: string, payload: array<mixed>}
     */
    public function jsonSerialize(): array
    {
        return [
            'commandName' => get_called_class(),
            'payload' => $this->getSerializablePayload(),
        ];
    }

    /**
     * @return array<mixed>
     */
    protected function getSerializablePayload(): array
    {
        $reflection = new \ReflectionClass($this);
        $serializedPayload = [];

        $properties = $reflection->getProperties();
        if ($parent = $reflection->getParentClass()) {
            $properties = [...$properties, ...$parent->getProperties()];
        }

        foreach ($properties as $property) {
            if (!$property->isInitialized($this)) {
                continue;
            }
            $serializedPayload[$property->getName()] = $property->getValue($this);
        }

        return $serializedPayload;
    }
}
