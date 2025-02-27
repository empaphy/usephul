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

namespace empaphy\usephul\var;

use empaphy\usephul\Type;

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
