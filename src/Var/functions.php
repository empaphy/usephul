<?php

/**
 * Variable handling Functions.
 *
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Types\Variables
 */

declare(strict_types=1);

namespace empaphy\usephul\Var;

use UnitEnum;

use function abs;
use function is_float;
use function is_int;
use function is_string;

/**
 * Default error tolerance.
 */
const ZERO_TOLERANCE = 0.00000000001;

/**
 * Finds whether the given variable is a resource that has been closed.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is closed-resource ? true : false)
 *   Returns `true` if __value__ is a `resource` variable that has been closed,
 *   `false` otherwise.
 */
function is_closed_resource(mixed $value): bool
{
    return Type::ClosedResource->is($value);
}

/**
 * Finds whether the given value is an enum case.
 *
 * @param  mixed  $value
 * @return bool
 */
function is_enum_case(mixed $value): bool
{
    return $value instanceof UnitEnum;
}

/**
 * Find whether a variable is an integer and less than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is negative-int ? true : false)
 *   Returns `true` if __value__ is a negative `integer`, `false` otherwise.
 */
function is_negative_int(mixed $value): bool
{
    return is_int($value) && $value < 0;
}

/**
 * Find whether a variable is a non-empty string.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-empty-string ? true : false)
 *   Returns `true` if value is a non-empty string, `false` otherwise.
 *
 * @phpstan-assert-if-true non-empty-string $value
 */
function is_non_empty_string(mixed $value): bool
{
    return ! empty($value) && is_string($value);
}

/**
 * Find whether a variable is an integer and not less than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-negative-int ? true : false)
 *   Returns `true` if __value__ is a non-negative `integer`, `false` otherwise.
 *
 * @phpstan-assert-if-true non-negative-int $value
 */
function is_non_negative_int(mixed $value): bool
{
    return is_int($value) && $value >= 0;
}

/**
 * Find whether a variable is an integer and not greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-positive-int ? true : false)
 *   Returns `true` if __value__ is a non-positive `integer`, `false` otherwise.
 *
 * @phpstan-assert-if-true non-positive-int $value
 */
function is_non_positive_int(mixed $value): bool
{
    return is_int($value) && $value <= 0;
}

/**
 * Find whether a variable is an integer and not zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-zero-int ? true : false)
 *   Returns `true` if __value__ is a non-zero `integer`, `false` otherwise.
 *
 * @phpstan-assert-if-true non-zero-int $value
 *
 * @noinspection PhpUndefinedClassInspection
 */
function is_non_zero_int(mixed $value): bool
{
    return is_int($value) && $value !== 0;
}

/**
 * Find whether a variable is a number (either an integer or a float).
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is number ? true : false)
 *   Returns `true` if __value__ is an `integer` or `float`, `false` otherwise.
 *
 * @phpstan-assert-if-true number $value
 */
function is_number(mixed $value): bool
{
    return is_int($value) || is_float($value);
}

/**
 * Find whether a variable is an integer and greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is positive-int ? true : false)
 *   Returns `true` if **value** is a positive `integer`, `false` otherwise.
 *
 * @phpstan-assert-if-true positive-int $value
 */
function is_positive_int(mixed $value): bool
{
    return is_int($value) && $value > 0;
}

/**
 * Finds whether the given number is (sufficiently close to) 0.
 *
 * @param  int|float   $value
 *   The number being evaluated.
 *
 * @param  float|null  $tolerance
 *   Tolerance allowed when evaluating the number.
 *
 * @return bool
 *   Returns `true` if __value__ is (sufficiently close to) `0`, `false`
 *   otherwise.
 *
 * @phpstan-assert-if-true ($value is int ? non-positive-int&non-negative-int : float) $value
 */
function is_zero(int|float $value, ?float $tolerance = ZERO_TOLERANCE): bool
{
    return 0 === $value
        || 0.0 === $value
        || (null !== $tolerance && abs($value) <= $tolerance);
}
