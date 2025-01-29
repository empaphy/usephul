<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\rephine
 */

declare(strict_types=1);

namespace empaphy\rephine;

use empaphy\rephine\Enumerations\EnumDynamicity;

/**
 * Possible types as returned by {@see gettype()}.
 */
enum Type: string
{
    use EnumDynamicity;

    /**
     * The {@link https://www.php.net/types.null null} type is PHP's unit type,
     * i.e. it has only one value: `null`.
     *
     * Undefined and {@link https://www.php.net/unset unset()} variables will
     * also resolve to the value `null`.
     */
    case Null = 'NULL';

    /**
     * The {@link https://www.php.net/types.boolean boolean} type only has two
     * values, and is used to express a truth value. It can be either `true` or
     * `false`.
     */
    case Boolean = 'boolean';

    /**
     * An {@link https://www.php.net/types.integer integer} is a number of the
     * set ℤ = {..., -2, -1, 0, 1, 2, ...}.
     */
    case Integer = 'integer';

    /**
     * A {@link https://www.php.net/types.float float} is a floating point
     * number, also known as a "double", or "real number".
     */
    case Float = 'double';

    /**
     * A {@link https://www.php.net/types.string string} is a series of
     * characters, where a character is the same as a byte.
     */
    case String = 'string';

    /**
     * An {@link https://www.php.net/types.array array} in PHP is actually an
     * ordered map. A map is a type that associates values to keys. This type is
     * optimized for several different uses; it can be treated as an array, list
     * (vector), hash table (an implementation of a map), dictionary,
     * collection, stack, queue, and probably more. As <u>array</u> values can
     * be other <u>array</u>s, trees and multidimensional <u>array</u>s are also
     * possible.
     */
    case Array = 'array';

    /**
     * An {@link https://www.php.net/types.object object} is an instance of a
     * class or {@link https://www.php.net/types.enumerations enumeration}.
     */
    case Object = 'object';

    /**
     * A {@link https://www.php.net/types.resource resource} is a special
     * variable, holding a reference to an external resource. Resources are
     * created and used by special functions.
     *
     * See the {@see https://www.php.net/resource appendix} for a listing of all
     * these functions and the corresponding resource types.
     *
     * @see https://php.net/get_resource_type the get_resource_type() function.
     */
    case Resource = 'resource';

    /**
     * Closed {@link https://www.php.net/types.resource resources} are reported
     * as `resource (closed)`.
     */
    case ClosedResource = 'resource (closed)';

    /**
     * A value of an unknown type.
     */
    case Unknown = 'unknown type';

    /**
     * Returns the {@see Type} of the provided value.
     *
     * @param  mixed  $value
     * @return self
     *
     * @throws \ValueError if the value is of an unknown type.
     */
    public static function of(mixed $value): self
    {
        return self::from(\gettype($value));
    }

    /**
     * Returns the {@see Type} of the provided value. If the value is of an
     * unknown type, it will return `null`.
     *
     * @param  mixed  $value
     * @return self|null
     */
    public static function tryOf(mixed $value): ?self
    {
        return self::tryFrom(\gettype($value));
    }

    /**
     * Checks whether the type of provided value matches this {@see Type}.
     *
     * @param mixed $value
     * @return bool
     */
    public function is(mixed $value): bool
    {
        return \gettype($value) === $this->value;
    }
}
