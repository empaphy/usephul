<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 */

declare(strict_types=1);

namespace empaphy\usephul;

use empaphy\usephul\var\Type;
use Generator;
use RangeException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;

use function is_string;
use function strlen;

/**
 * Finds whether an attribute has been applied to a given object, class,
 * interface, or trait.
 *
 * @package Types\Attributes
 *
 * @param  object|class-string  $object_or_class
 *   A class name or an object instance.
 *
 * @param  class-string  $attribute
 *   The attribute name.
 *
 * @return bool
 *   `true` if the attribute has been applied to the given object or class.
 *   `false` otherwise.
 */
function applies(object|string $object_or_class, string $attribute): bool
{
    $type = Type::of($object_or_class);

    try {
        $reflector = match ($type) {
            Type::Object => new ReflectionObject($object_or_class),
            Type::String => new ReflectionClass($object_or_class),
            default => null,
        };
    } catch (ReflectionException $e) {
        return false;
    }

    if (null === $reflector) {
        return false;
    }

    return ! empty($reflector->getAttributes(
        $attribute,
        ReflectionAttribute::IS_INSTANCEOF
    ));
}

/**
 * Sequences a value into a Generator.
 *
 * @param  mixed  $value  The value to sequence.
 * @return Generator<string|int>
 * @package Generators
 *
 */
function seq(mixed $value): Generator
{
    switch (Type::of($value)) {
        case Type::Boolean:
            yield $value;
            break;

        case Type::ClosedResource:
        case Type::Null:
            yield null;
            break;

        case Type::Integer:
            $value = (string) $value;
            $size = strlen($value);
            for ($i = 0; $i < $size; $i++) {
                yield (int) $value[$i];
            }
            break;

        case Type::Float:
            // I'm not sure how to sequence floats yet, so I'm simply not
            // supporting them for now.
            throw new RangeException('Sequencing floats is not supported.');

        case Type::String:
            $size = strlen($value);
            for ($i = 0; $i < $size; $i++) {
                yield $value[$i];
            }
            break;

        case Type::Object:
        case Type::Array:
        case Type::Unknown:
            foreach ($value as $key => $item) {
                yield $key => $item;
            }
            break;

        case Type::Resource:
            // I'm not sure how to sequence resources yet, so I'm simply not
            // supporting them for now.
            throw new RangeException('Sequencing resources is not supported.');
    }
}

/**
 * Checks whether an object or class uses a given trait.
 *
 * @package Types\Traits
 *
 * @param  object|string  $object_or_class
 *   A class name or an object instance.
 *
 * @param  string  $trait
 *   The trait name.
 *
 * @param  bool  $allow_string
 *   If this parameter is set to `false`, a string class name as
 *   __object_or_class__ is not allowed. This also prevents from calling
 *   autoloader if the class doesn't exist.
 *
 * @return bool
 *   This function returns `true` if __object_or_class__, any of its traits,
 *   any of its parents, or its parents' traits, use __trait__. `false`
 *   otherwise.
 */
function uses(
    object|string $object_or_class,
    string $trait,
    bool $allow_string = true
): bool {
    if (false === $allow_string && is_string($object_or_class)) {
        return false;
    }

    return isset(class_traits_uses($object_or_class, $allow_string)[$trait])
        || isset(class_parents_traits_uses($object_or_class, $allow_string)[$trait]);
}
