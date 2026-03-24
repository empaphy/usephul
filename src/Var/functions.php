<?php

/**
 * Variable handling Functions.
 *
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Types\Variables
 *
 * @noinspection PhpUndefinedClassInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\Var;

use UnitEnum;

use function abs;
use function array_is_list;
use function class_exists;
use function gettype;
use function interface_exists;
use function is_array;
use function is_float;
use function is_int;
use function is_numeric;
use function is_scalar;
use function is_string;
use function trait_exists;
use function trigger_error;

use const E_USER_WARNING;

/**
 * Default error tolerance.
 */
const ZERO_TOLERANCE = 0.00000000001;

/**
 * Determines if the given value is a valid array key.
 *
 * For regular arrays, a valid array key is either an `integer` or a `string`.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is array-key ? true : false)
 *   Returns `true` if __value__ is a valid array key, `false` otherwise.
 *
 * @phpstan-assert-if-true array-key $value
 */
function is_array_key(mixed $value): bool
{
    return is_int($value) || is_string($value);
}

/**
 * Determines if the given value is an associative array.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is associative-array ? true : false)
 *   Returns `true` if __value__ is an associative array, `false` otherwise.
 *
 * @phpstan-assert-if-true associative-array $value
 */
function is_associative_array(mixed $value): bool
{
    return is_array($value) && ! array_is_list($value);
}

/**
 * Determines whether the given value is a boolean.
 *
 * This function is an alias of: {@see is_bool()}.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is boolean ? true : false)
 *   Returns `true` if value is a `bool`, `false` otherwise.
 *
 * @see is_float() - Determines if a value is a `float`.
 * @see is_int() - Determines if a value is an `integer`.
 * @see is_string() - Determines if a value is a `string`.
 * @see is_object() - Determines if a value is an `object`.
 * @see is_array() - Determines if a value is an `array`.
 *
 * @phpstan-assert-if-true boolean $value
 */
function is_boolean(mixed $value): bool
{
    return is_bool($value);
}

/**
 * Determines if the given value is a callable array.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is callable-array ? true : false)
 *   Returns `true` if __value__ is a callable array, `false` otherwise.
 *
 * @phpstan-assert-if-true callable-array $value
 */
function is_callable_array(mixed $value): bool
{
    return is_array($value) && is_callable($value);
}

/**
 * Determines if the given value is a callable object.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is callable-object ? true : false)
 *   Returns `true` if __value__ is a callable object, `false` otherwise.
 *
 * @phpstan-assert-if-true callable-object $value
 */
function is_callable_object(mixed $value): bool
{
    return is_object($value) && is_callable($value);
}

/**
 * Determines if the given value is a callable string.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is callable-string ? true : false)
 *   Returns `true` if __value__ is a callable string, `false` otherwise.
 *
 * @phpstan-assert-if-true callable-string $value
 */
function is_callable_string(mixed $value): bool
{
    return is_string($value) && is_callable($value);
}

/**
 * Determines if the given value is a valid class name string.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @param  bool  $autoload
 *   Whether to autoload if not already loaded.
 *
 * @return ($value is class-string ? true : false)
 *   Returns `true` if __value__ is a valid class name, `false` otherwise.
 *
 * @see is_interface_string() - Determines if a value is a valid interface name.
 * @see is_trait_string() - Determines if a value is a valid trait name.
 *
 * @phpstan-assert-if-true class-string $value
 */
function is_class_string(mixed $value, bool $autoload = true): bool
{
    return is_string($value) && class_exists($value, $autoload);
}

/**
 * Determines if the given value is a resource that has been closed.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is closed-resource ? true : false)
 *   Returns `true` if __value__ is a `resource` variable that has been closed,
 *   `false` otherwise.
 *
 * @phpstan-assert-if-true closed-resource $value
 */
function is_closed_resource(mixed $value): bool
{
    return gettype($value) === 'resource (closed)';
}

/**
 * Determines if the given value is empty.
 *
 * A value is considered empty if its value evaluates to `false`. Unlike
 * {@see empty()}, {@see is_empty()} _does_ trigger a warning if the variable
 * does not exist.
 *
 * @param  mixed  $value
 *   Variable to be checked
 *
 *   Unlike with {@see empty()}, a warning is triggered if the variable does
 *   not exist. That means this is essentially the concise equivalent to
 *   `$var == false`. This also applies to nested structures, such as a
 *   multidimensional array or chained properties.
 *
 * @return ($value is empty ? true : false)
 *   Returns `true` if __var__ has a value that is empty or equal to zero, aka
 *   falsey. Otherwise returns `false`.
 *
 * @link https://php.net/boolean#language.types.boolean.casting Converting to boolean
 *
 * @phpstan-assert-if-true empty $value
 */
function is_empty(mixed $value): bool
{
    return empty($value);
}

/**
 * Determines if the given value is an empty scalar.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is empty-scalar ? true : false)
 *   Returns `true` if __value__ is an empty scalar, `false` otherwise.
 *
 * @phpstan-assert-if-true empty-scalar $value
 */
function is_empty_scalar(mixed $value): bool
{
    return empty($value) && is_scalar($value);
}

/**
 * Determines if the given value is an enum case.
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
 * Determines if the given value is false.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is false ? true : false)
 *   Returns `true` if __value__ is `false`, `false` otherwise.
 *
 * @phpstan-assert-if-true false $value
 */
function is_false(mixed $value): bool
{
    return false === $value;
}

/**
 * Determines if the given value is a valid interface name string.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @param  bool  $autoload
 *   Whether to autoload if not already loaded.
 *
 * @return ($value is interface-string ? true : false)
 *   Returns `true` if __value__ is a valid interface name, `false` otherwise.
 *
 * @see is_class_string() - Determines if a value is a valid class name.
 * @see is_trait_string() - Determines if a value is a valid trait name.
 *
 * @phpstan-assert-if-true interface-string $value
 */
function is_interface_string(mixed $value, bool $autoload = true): bool
{
    return is_string($value) && interface_exists($value, $autoload);
}

/**
 * Determines if the given value is a list.
 *
 * A list is an array with keys consisting of consecutive numbers from `0` to
 * `count($array)-1`.
 *
 * > __Note__:
 * >
 * > This function returns `true` on empty arrays.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is list ? true : false)
 *   Returns `true` if __value__ is a list, `false` otherwise.
 *
 * @phpstan-assert-if-true list $value
 */
function is_list(mixed $value): bool
{
    return is_array($value) && array_is_list($value);
}

/**
 * Determines if the given value is an integer and less than zero.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is negative-int ? true : false)
 *   Returns `true` if __value__ is a negative `integer`, `false` otherwise.
 *
 * @phpstan-assert-if-true negative-int $value
 */
function is_negative_int(mixed $value): bool
{
    return is_int($value) && $value < 0;
}

/**
 * Determines if the given value is a non-empty array.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is non-empty-array ? true : false)
 *   Returns `true` if __value__ is a non-empty array, `false` otherwise
 *
 * @phpstan-assert-if-true non-empty-array $value
 */
function is_non_empty_array(mixed $value): bool
{
    return $value && is_array($value);
}

/**
 * Determines if the given value is a non-empty list.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @return ($value is non-empty-list ? true : false)
 *   Returns `true` if __value__ is a non-empty list, `false` otherwise.
 *
 * @phpstan-assert-if-true non-empty-list $value
 */
function is_non_empty_list(mixed $value): bool
{
    return $value && is_array($value) && array_is_list($value);
}

/**
 * Determines if the given value is a non-empty mixed value.
 *
 * `non-empty-mixed` is a `mixed` that excludes falsy values (`false`, `0`,
 * `0.0`, `''`, `'0'`, `[]`, and `null`).
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-empty-mixed ? true : false)
 *
 * @phpstan-assert-if-true non-empty-mixed $value
 */
function is_non_empty_mixed(mixed $value): bool
{
    return ! empty($value);
}

/**
 * Determines if the given value is a non-empty scalar.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-empty-scalar ? true : false)
 *   Returns `true` if __value__ is a non-empty scalar, `false` otherwise.
 *
 * @phpstan-assert-if-true non-empty-scalar $value
 */
function is_non_empty_scalar(mixed $value): bool
{
    return ! empty($value) && is_scalar($value);
}

/**
 * Determines if the given value is a non-empty string.
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
 * Determines if the given value is a non-falsy string.
 *
 * A `non-falsy-string` (also known as `truthy-string`) is any string that is
 * `true` after casting to boolean.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is non-falsy-string ? true : false)
 *   Returns `true` if __value__ is a non-falsy string, `false` otherwise.
 *
 * @phpstan-assert-if-true non-falsy-string $value
 */
function is_non_falsy_string(mixed $value): bool
{
    return $value && is_string($value);
}

/**
 * Determines if the given value is an integer and not less than zero.
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
 * Determines if the given value is an integer and not greater than zero.
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
 * Determines if the given value is an integer and not zero.
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
 * Determines if the given value is a number (either an integer or a float).
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
 * Determines if the given value is a numeric string.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is numeric-string ? true : false)
 *   Returns `true` if __value__ is an `integer` or `float`, `false` otherwise.
 *
 * @phpstan-assert-if-true numeric-string $value
 */
function is_numeric_string(mixed $value): bool
{
    return is_string($value) && is_numeric($value);
}

/**
 * Determines if the given value is a resource that is still open.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is open-resource ? true : false)
 *   Returns `true` if __value__ is a `resource` variable that is still open,
 *   `false` otherwise.
 *
 * @phpstan-assert-if-true open-resource $value
 */
function is_open_resource(mixed $value): bool
{
    return gettype($value) === 'resource';
}

/**
 * Determines if the given value is an integer and greater than zero.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is positive-int ? true : false)
 *   Returns `true` if __value__ is a positive `integer`, `false` otherwise.
 *
 * @phpstan-assert-if-true positive-int $value
 */
function is_positive_int(mixed $value): bool
{
    return is_int($value) && $value > 0;
}

/**
 * Determines if the given value is an instance of the current class.
 *
 * If the scope where this function is called from is not an object, a
 * {@see E_USER_WARNING warning} is emitted.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return bool
 *   Returns `true` if __value__ is an instance of the current class,
 *   `false` otherwise.
 */
function is_self(mixed $value): bool
{
    // TODO
    trigger_error(
        'is_parent() should be called from an object context',
        E_USER_WARNING,
    );
}

/**
 * Determines if the given value is an instance of the current class, or a
 * child class
 *
 * If the scope where this function is called from is not an object, a
 * {@see E_USER_WARNING warning} is emitted.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return bool
 *   Returns `true` if __value__ is an instance of the current/child class,
 *   `false` otherwise.
 */
function is_static(mixed $value): bool
{
    // TODO
    trigger_error(
        'is_parent() should be called from an object context',
        E_USER_WARNING,
    );
}

/**
 * Determines if the given value is a valid trait name string.
 *
 * @param  mixed  $value
 *   The value being evaluated.
 *
 * @param  bool  $autoload
 *   Whether to autoload if not already loaded.
 *
 * @return ($value is trait-string ? true : false)
 *   Returns `true` if __value__ is a valid trait name, `false` otherwise.
 *
 * @see is_class_string() - Determines if a value is a valid class name.
 * @see is_interface_string() - Determines if a value is a valid interface name.
 *
 * @phpstan-assert-if-true trait-string $value
 */
function is_trait_string(mixed $value, bool $autoload = true): bool
{
    return is_string($value) && trait_exists($value, $autoload);
}

/**
 * Determines if the given value is a truthy string.
 *
 * A `truthy-string` (also known as `non-falsy-string`) is any string that is
 * `true` after casting to boolean.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is truthy-string ? true : false)
 *   Returns `true` if __value__ is a truthy string, `false` otherwise.
 *
 * @phpstan-assert-if-true truthy-string $value
 */
function is_truthy_string(mixed $value): bool
{
    return $value && is_string($value);
}

/**
 * Determines if the given value is an instance of the current parent class.
 *
 * If the scope where this function is called from is not an object, a
 * {@see E_USER_WARNING warning} is emitted.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return bool
 *   Returns `true` if __value__ is an instance of the current parent class,
 *   `false` otherwise.
 */
function is_parent(mixed $value): bool
{
    // TODO
    trigger_error(
        'is_parent() should be called from an object context',
        E_USER_WARNING,
    );
}

/**
 * Determines if the given value is boolean true.
 *
 * @param  mixed  $value
 *   The variable being evaluated.
 *
 * @return ($value is true ? true : false)
 *   Returns `true` if __value__ is `true`, `false` otherwise.
 *
 * @phpstan-assert-if-true true $value
 */
function is_true(mixed $value): bool
{
    return true === $value;
}

/**
 * Determines if the given callable has void as it's return type.
 *
 * @param  callable  $value
 *   The callable to check.
 *
 * @return ($value is callable(): void ? true : false)
 *
 * @phpstan-assert-if-true callable(): void $value
 */
function is_void(callable $value): bool
{
    // TODO
}

/**
 * Determines if the given number is (sufficiently close to) 0.
 *
 * @param  int|float  $value
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
