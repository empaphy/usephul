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

/**
 * Default error tolerance.
 */
const PHP_ZERO_TOLERANCE = 0.00000000001;

/**
 * Finds whether the given variable is a resource that has been closed.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is closed-resource ? true : false)
 *   Returns <u>true</u> if **value** is a <u>resource</u> variable that has
 *   been closed, <u>false</u> otherwise.
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
 *   Returns <u>true</u> if **value** is a negative <u>integer</u>,
 *   <u>false</u> otherwise.
 */
function is_negative_int(mixed $value): bool
{
    return \is_int($value) && $value < 0;
}

/**
 * Find whether a variable is a non-empty string.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-empty-string ? true : false)
 *   Returns <u>true</u> if value is a non-empty string, <u>false</u> otherwise.
 */
function is_non_empty_string(mixed $value): bool
{
    return ! empty($value) && \is_string($value);
}

/**
 * Find whether a variable is an integer and not less than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-negative-int ? true : false)
 *   Returns <u>true</u> if **value** is a non-negative <u>integer</u>,
 *   <u>false</u> otherwise.
 */
function is_non_negative_int(mixed $value): bool
{
    return \is_int($value) && $value >= 0;
}

/**
 * Find whether a variable is an integer and not greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-positive-int ? true : false)
 *   Returns <u>true</u> if **value** is a non-positive <u>integer</u>,
 *   <u>false</u> otherwise.
 */
function is_non_positive_int(mixed $value): bool
{
    return \is_int($value) && $value <= 0;
}

/**
 * Find whether a variable is an integer and not zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-zero-int ? true : false)
 *   Returns <u>true</u> if **value** is a non-zero <u>integer</u>, <u>false</u>
 *   otherwise.
 *
 * @noinspection PhpUndefinedClassInspection
 */
function is_non_zero_int(mixed $value): bool
{
    return \is_int($value) && $value !== 0;
}

/**
 * Find whether a variable is a number (either an integer or a float).
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is number ? true : false)
 *   Returns <u>true</u> if **value** is an <u>integer</u> or a <u>float</u>,
 *   <u>false</u> otherwise.
 */
function is_number(mixed $value): bool
{
    return \is_int($value) || \is_float($value);
}

/**
 * Find whether a variable is an integer and greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is positive-int ? true : false)
 *   Returns <u>true</u> if **value** is a positive <u>integer</u>, <u>false</u>
 *   otherwise.
 */
function is_positive_int(mixed $value): bool
{
    return \is_int($value) && $value > 0;
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
 *   Returns <u>true</u> if **value** is (sufficiently close to) `0`,
 *   <u>false</u> otherwise.
 */
function is_zero(int | float $value, ?float $tolerance = PHP_ZERO_TOLERANCE): bool
{
    return 0 === $value || 0.0 === $value || (null !== $tolerance && \abs($value) <= $tolerance);
}
