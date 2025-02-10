<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\rephine;

/**
 * Interchange the values of two elements of an array.
 *
 * If a **key** doesn't exist in the **array**, then the other key will be set
 * to `null`, and a warning will be thrown.
 *
 * @package Arrays
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param  array<TKey, TValue>  $array
 * @param  TKey                 $key1
 * @param  TKey                 $key2
 * @return array<TKey, TValue>
 *
 * @noinspection PhpDocSignatureInspection
 */
function array_interchange(array $array, int|string $key1, int|string $key2): array
{
    return [
        ...$array,
        $key1 => $array[$key2],
        $key2 => $array[$key1],
    ];
}

/**
 * Finds whether the given variable is a
 * {@link https://www.php.net/types.resource resource} that has been closed.
 *
 * @package Types
 *
 * @template T
 *
 * @param  T  $value  The variable being evaluated.
 * @return (T is resource ? bool : false) Returns `true` if **value** is a
 *                                        <u>resource</u> variable that has been
 *                                        closed, `false` otherwise.
 */
function is_closed_resource(mixed $value): bool
{
    return Type::ClosedResource->is($value);
}

/**
 * Finds whether the given number is (sufficiently close to) 0.
 *
 * @package Types
 *
 * @param  int|float   $value      The number being evaluated.
 * @param  float|null  $tolerance  Tolerance allowed when evaluating the number.
 * @return bool Returns <u>true</u> if **value** is (sufficiently close to) 0,
 *              <u>false</u> otherwise.
 */
function is_zero(int | float $value, ?float $tolerance = PHP_ZERO_TOLERANCE): bool
{
    return 0 === $value || 0.0 === $value || (null !== $tolerance && \abs($value) <= $tolerance);
}

/**
 * Sequences a value into a {@see \Generator}.
 *
 * @package Generators
 *
 * @param  mixed  $value  The value to sequence.
 * @return \Generator<string|int>
 */
function seq(mixed $value): \Generator
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
            $size = \strlen($value);
            for ($i = 0; $i < $size; $i++) {
                yield (int) $value[$i];
            }
            break;

        case Type::Float:
            // I'm not sure how to sequence floats yet, so I'm simply not
            // supporting them for now.
            throw new \RangeException('Sequencing floats is not supported.');

        case Type::String:
            $size = \strlen($value);
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
            throw new \RangeException('Sequencing resources is not supported.');
    }
}

/**
 * Checks whether an object or class uses a given trait.
 *
 * @package Types
 *
 * @param  object|string $object_or_class  A class name or an object instance.
 * @param  string        $trait            The trait name.
 * @param  bool          $allow_string     If this parameter set to false,
 *                                         string class name as object_or_class
 *                                         is not allowed. This also prevents
 *                                         from calling autoloader if the class
 *                                         doesn't exist.
 * @return bool
 */
function uses(
    object|string $object_or_class,
    string $trait,
    bool $allow_string = true
): bool {
    if (false === $allow_string && \is_string($object_or_class)) {
        return false;
    }

    return \in_array(
        $trait,
        \class_uses($object_or_class, $allow_string),
        true,
    );
}
