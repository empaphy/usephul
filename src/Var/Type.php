<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Types
 */

declare(strict_types=1);

namespace empaphy\usephul\Var;

use empaphy\usephul\Enumerations\EnumDynamicity;
use ValueError;

use function gettype;

/**
 * Possible types as returned by {@see gettype()}.
 */
enum Type: string
{
    use EnumDynamicity;

    /**
     * The null type is PHP's unit type, i.e. it has only one value: NULL.
     *
     * Undefined and {@link https://www.php.net/unset unset()} variables will
     * also resolve to the value `null`.
     */
    case Null = 'NULL';

    /**
     * The boolean type only has two values, and is used to express a truth
     * value. It can be either `true` or `false`.
     */
    case Boolean = 'boolean';

    /**
     * An integer is a number of the set ℤ = {..., -2, -1, 0, 1, 2, ...}.
     */
    case Integer = 'integer';

    /**
     * A "float" is a floating point number, also known as a "double", or
     * "real number".
     */
    case Float = 'double';

    /**
     * A string is a series of characters, where a character is the same as
     * a byte.
     */
    case String = 'string';

    /**
     * An array in PHP is actually an ordered map. A map is a type that
     * associates values to keys.
     *
     * This type is optimized for several different uses; it can be treated
     * as an array, list (vector), hash table (an implementation of a map),
     * dictionary, collection, stack, queue, and probably more. As
     * {@link https://www.php.net/types.array array} values can be other
     * `array`s, trees and multidimensional `array`s are also possible.
     */
    case Array = 'array';

    /**
     * An object is an instance of a class or an enumeration.
     */
    case Object = 'object';

    /**
     * A resource is a special variable, holding a reference to an external
     * resource. Resources are created and used by special functions.
     *
     * See the {@see https://www.php.net/resource appendix} for a listing of
     * all these functions and the corresponding
     * {@link https://www.php.net/types.resource resource} types.
     *
     * See also the
     * {@link https://php.net/get_resource_type get_resource_type()} function.
     */
    case Resource = 'resource';

    /**
     * Closed resources are reported as "resource (closed)".
     */
    case ClosedResource = 'resource (closed)';

    /**
     * A value of an unknown type.
     */
    case Unknown = 'unknown type';

    /**
     * Returns the Type instance of the provided value.
     *
     * @param  mixed  $value
     *   The value for which to deduce the type.
     *
     * @return self
     *   A Type case instance.
     *
     * @throws ValueError
     *   Thrown if the value is of an unknown type.
     */
    public static function of(mixed $value): self
    {
        return self::from(gettype($value));
    }

    /**
     * Returns the Type of the provided value. If the value is of an unknown
     * type, it will return NULL.
     *
     * @param  mixed  $value
     *   The value for which to try to deduce the type.
     *
     * @return self|null
     *   A Type case instance, or `null` if __value__ is of an unknown type.
     */
    public static function tryOf(// @phpstan-ignore return.unusedType
        mixed $value,
    ): ?self {
        return self::tryFrom(gettype($value));
    }

    /**
     * Checks whether the type of provided value matches this {@see Type}.
     *
     * @param mixed $value
     *   The value to check.
     *
     * @return bool
     *   Returns `true` if __value__ matches this {@see Type}, `false`
     *   otherwise.
     */
    public function is(mixed $value): bool
    {
        return gettype($value) === $this->value;
    }
}
