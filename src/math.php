<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Math
 */

declare(strict_types=1);

namespace empaphy\usephul\math;

use BackedEnum;
use Countable;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;
use IntBackedEnum;
use InvalidArgumentException;
use Stringable;
use StringBackedEnum;
use UnitEnum;

use function get_debug_type;
use function sprintf;

/**
 * Finds the value that is greater than all the other values.
 *
 * @template TValue
 *
 * @param  TValue  ...$values
 * @return TValue
 */
function greatest(mixed ...$values): mixed
{
    return array_reduce(
        $values,
        static fn($carry, $item) => rank($item) > rank($carry) ? $item : $carry,
    );
}

/**
 * Finds the value that is less than all the other values.
 *
 * @template TValue
 *
 * @param  TValue  ...$values
 * @return TValue
 */
function least(mixed ...$values): mixed
{
    return array_reduce(
        $values,
        static fn($carry, $item) => rank($item) < rank($carry) ? $item : $carry,
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
 *     TValue is DateTimeInterface ? float  : (
 *     TValue is DateInterval      ? float  : (
 *     TValue is DatePeriod        ? float  : (
 *     TValue is IntBackedEnum     ? int    : (
 *     TValue is StringBackedEnum  ? string : (
 *     TValue is UnitEnum          ? string : (
 *     TValue is Stringable        ? string : (
 *     TValue is Countable         ? int    : (
 *     TValue is int               ? TValue : (
 *     TValue is float             ? TValue : (
 *     TValue is string            ? TValue : (
 *     TValue is array             ? array  : (
 *     TValue is object            ? array  :
 *     never )))))))))))))
 *   A value that represents the rank for the given __value__.
 *
 * @throws InvalidArgumentException if the given __value__ is not supported.
 */
function rank(mixed $value): null | bool | int | float | string | array
{
    switch (true) {
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
            return rank(current($value));

        case is_array($value):
            return array_map(__FUNCTION__, $value);

        case $value instanceof Stringable:
            return $value->__toString();

        case $value instanceof Countable:
            return $value->count();

        case is_object($value):
            return rank((array) $value);

        default:
            throw new InvalidArgumentException(sprintf(
                'Value of type %s is not supported (yet)',
                get_debug_type($value),
            ));
    }
}
