<?php

/**
 * Variable handling Functions.
 *
 * A common use case for these functions is in combination as type guard:
 *
 *     if (is_non_empty_string($value)) {
 *         // $value is non-empty string
 *     }
 *
 * These functions are all compatible with PHPStan, so you can use them for
 * type-narrowing:
 *
 *     assert(is_non_empty_string($value));
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
 * Determine if a given value is a resource that has been closed.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is closed-resource ? true : false)
 *   Returns `true` if __value__ is a `resource` variable that has been closed,
 *   `false` otherwise.
 *
 * @see is_resource() - Determines if a given value is a resource.
 *
 * @phpstan-assert-if-true closed-resource $value
 */
function is_closed_resource(mixed $value): bool
{
    return gettype($value) === 'resource (closed)';
}

/**
 * Determine if a given value is an enum case.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is UnitEnum ? true : false)
 *   Returns `true` if __value__ is an enum case, `false` otherwise.
 *
 * @phpstan-assert-if-true UnitEnum $value
 */
function is_enum_case(mixed $value): bool
{
    return $value instanceof UnitEnum;
}

/**
 * Determine if a given value is an integer and less than zero.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is negative-int ? true : false)
 *   Returns `true` if __value__ is a negative `integer`, `false` otherwise.
 *
 * @see is_non_negative_int()
 *   - Determine if a given value is an integer and not less than zero.
 * @see is_non_positive_int()
 *   - Determine if a given value is an integer and not greater than zero.
 * @see is_positive_int()
 *   - Determine if a given value is an integer and greater than zero.
 *
 * @phpstan-assert-if-true negative-int $value
 */
function is_negative_int(mixed $value): bool
{
    return is_int($value) && $value < 0;
}

/**
 * Determine if a given value is a non-empty string.
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
    return is_string($value) && $value !== '';
}

/**
 * Determine if a given value is an integer and not less than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-negative-int ? true : false)
 *   Returns `true` if __value__ is a non-negative `integer`, `false` otherwise.
 *
 * @see is_negative_int()
 *   - Determine if a given value is an integer and less than zero.
 * @see is_non_positive_int()
 *   - Determine if a given value is an integer and not greater than zero.
 * @see is_positive_int()
 *   - Determine if a given value is an integer and greater than zero.
 *
 * @phpstan-assert-if-true non-negative-int $value
 */
function is_non_negative_int(mixed $value): bool
{
    return is_int($value) && $value >= 0;
}

/**
 * Determine if a given value is an integer and not greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-positive-int ? true : false)
 *   Returns `true` if __value__ is a non-positive `integer`, `false` otherwise.
 *
 * @see is_negative_int()
 *   - Determine if a given value is an integer and less than zero.
 * @see is_non_negative_int()
 *   - Determine if a given value is an integer and not less than zero.
 * @see is_positive_int()
 *   - Determine if a given value is an integer and greater than zero.
 *
 * @phpstan-assert-if-true non-positive-int $value
 */
function is_non_positive_int(mixed $value): bool
{
    return is_int($value) && $value <= 0;
}

/**
 * Determine if a given value is an integer and not zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-zero-int ? true : false)
 *   Returns `true` if __value__ is a non-zero `integer`, `false` otherwise.
 *
 * @see is_zero()
 *   - Determine if a given number is (close enough to) 0.
 *
 * @noinspection PhpUndefinedClassInspection
 * @phpstan-assert-if-true non-zero-int $value
 */
function is_non_zero_int(mixed $value): bool
{
    return is_int($value) && $value !== 0;
}

/**
 * Determine if a given value is a number (either an integer or a float).
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
 * Determine if a given value is an integer and greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is positive-int ? true : false)
 *   Returns `true` if __value__ is a positive `integer`, `false` otherwise.
 *
 * @see is_negative_int()
 *   - Determine if a given value is an integer and less than zero.
 * @see is_non_negative_int()
 *   - Determine if a given value is an integer and not less than zero.
 * @see is_non_positive_int()
 *   - Determine if a given value is an integer and not greater than zero.
 *
 * @phpstan-assert-if-true positive-int $value
 */
function is_positive_int(mixed $value): bool
{
    return is_int($value) && $value > 0;
}

/**
 * Determine if a given number is (close enough to) 0.
 *
 * @param  int|float  $value
 *   The number being evaluated.
 *
 * @param  float|null  $tolerance
 *   Tolerance allowed when evaluating the number.
 *
 * @return ($value is int<0,0> ? true : bool)
 *   Returns `true` if __value__ is (sufficiently close to) `0`, `false`
 *   otherwise.
 *
 * @see is_non_zero_int()
 *   Determine if a given value is an integer and not zero.
 *
 * @phpstan-assert-if-true ($value is int ? int<0,0> : float) $value
 */
function is_zero(int|float $value, ?float $tolerance = ZERO_TOLERANCE): bool
{
    return 0 === $value
        || 0.0 === $value
        || null !== $tolerance && abs($value) <= $tolerance;
}
