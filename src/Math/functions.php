<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Math
 */

declare(strict_types=1);

namespace empaphy\usephul\Math;

use BackedEnum;
use Countable;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Stringable;
use UnitEnum;

use function array_map;
use function array_reduce;
use function current;
use function get_debug_type;
use function is_array;
use function is_float;
use function is_int;
use function is_object;
use function is_string;
use function sprintf;

/**
 * Finds the value that is greater than all the other values.
 *
 * @template TValue
 *
 * @param  TValue  $value1
 *   Any {@see rank() rankable} value.
 *
 * @param  TValue  $value2
 *   Any {@see rank() rankable} value.
 *
 * @param  TValue[]  ...$values
 *   Any {@see rank() rankable} values.
 *
 * @return TValue
 *   Returns the greatest of the given values.
 */
function greatest(mixed $value1, mixed $value2, mixed ...$values): mixed
{
    return array_reduce(
        [$value2, ...$values],
        static fn($carry, $item) => rank($item) > rank($carry) ? $item : $carry,
        $value1,
    );
}

/**
 * Finds the value that is less than all the other values.
 *
 * @template TValue
 *
 * @param  TValue  $value1
 *   Any {@see rank() rankable} value.
 *
 * @param  TValue  $value2
 *   Any {@see rank() rankable} value.
 *
 * @param  TValue[]  ...$values
 *   Any {@see rank() rankable} values.
 *
 * @return TValue
 */
function least(mixed $value1, mixed $value2, mixed ...$values): mixed
{
    return array_reduce(
        [$value2, ...$values],
        static fn($carry, $item) => rank($item) < rank($carry) ? $item : $carry,
        $value1,
    );
}

/**
 * Returns the ordinal rank for a given value.
 *
 * This rank can be compared reliably using traditional comparison operators,
 * like `<` and `>=`.
 *
 * @template TValue
 *
 * @param  TValue  $value
 *   The value to rank.
 *
 * @return (
 *     TValue is DateTimeInterface ? float            : (
 *     TValue is DateInterval      ? float            : (
 *     TValue is DatePeriod        ? float            : (
 *     TValue is BackedEnum        ? value-of<TValue> : (
 *     TValue is UnitEnum          ? string           : (
 *     TValue is Stringable        ? string           : (
 *     TValue is Countable         ? int              : (
 *     TValue is null              ? int<0,0>         : (
 *     TValue is false             ? int<0,0>         : (
 *     TValue is true              ? int<1,1>         : (
 *     TValue is int               ? TValue           : (
 *     TValue is float             ? TValue           : (
 *     TValue is string            ? TValue           : (
 *     TValue is array             ? array            : (
 *     TValue is object            ? array            :
 *     never )))))))))))))))
 *   A value that represents the ordinal rank for the given __value__.
 *
 * @throws InvalidArgumentException
 *   Thrown if the given __value__ is not supported.
 *
 * @noinspection PhpDocSignatureInspection
 */
function rank(mixed $value): int|float|string|array
{
    switch (true) {
        case null === $value:
        case false === $value:
            return 0;

        case true === $value:
            return 1;

        case is_int($value):
        case is_float($value):
        case is_string($value):
            return $value;

        case $value instanceof BackedEnum:
            return $value->value;

        case $value instanceof UnitEnum:
            return $value->name;

        case $value instanceof DateTimeInterface:
            return (float) $value->format('U.u');

        case $value instanceof DateInterval:
            $ref = new DateTimeImmutable();
            return rank($ref->add($value)) - rank($ref);

        case $value instanceof DatePeriod:
            return rank(current(iterator_to_array($value)));

        case $value instanceof Stringable:
            return $value->__toString();

        case $value instanceof Countable:
            return $value->count();

        case is_array($value):
            return array_map(__FUNCTION__, $value);

        case is_object($value):
            return rank((array) $value);

        default:
            throw new InvalidArgumentException(sprintf(
                'Value of type %s is not supported (yet)',
                get_debug_type($value),
            ));
    }
}
