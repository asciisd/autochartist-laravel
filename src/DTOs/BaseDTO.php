<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs;

use ReflectionClass;
use ReflectionProperty;

/**
 * Base Data Transfer Object
 *
 * Abstract base class for all DTO objects providing:
 * - Automatic snake_case conversion for API fields
 * - Null value filtering
 * - Consistent array transformation
 */
abstract readonly class BaseDTO
{
    /**
     * Convert DTO to array for API request.
     */
    abstract public function toArray(): array;

    /**
     * Filter null values from array.
     */
    protected function filterNullValues(array $data): array
    {
        return array_filter($data, fn($value) => $value !== null);
    }

    /**
     * Automatically convert DTO properties to snake_case array.
     * 
     * Use this for simple DTOs without custom field mappings.
     */
    protected function toSnakeCaseArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        $data = [];
        foreach ($properties as $property) {
            $value = $property->getValue($this);
            if ($value !== null) {
                $snakeCase = $this->camelToSnake($property->getName());
                $data[$snakeCase] = $value;
            }
        }

        return $data;
    }

    /**
     * Convert camelCase string to snake_case.
     */
    private function camelToSnake(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }
}