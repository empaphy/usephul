<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable;

use Traversable;

/**
 * Checks if all iterable elements satisfy a callback function.
 *
 * {@see all()} returns `true`, if the given **callback** returns
 * `true` for all elements. Otherwise, the method returns `false`.
 *
 * @template K
 * @template V
 *
 * @param  iterable<K, V>  $iterable
 *   The iterable that should be searched.
 *
 * @param  callable(V $value, K $key): bool  $callback
 *   The callback function to call to check each element. If this function
 *   returns `false`, `false` is returned from {@see all()} and the callback
 *   will not be called for further elements.
 *
 * @return bool
 *   The method returns `true` if **callback** returns `true` for all
 *   elements. Otherwise, the method returns `false`.
 */
function all(iterable $iterable, callable $callback): bool
{
//    if ($iterable instanceof Traversable) {
        $iterable = iterator_to_array($iterable);
//    }

    return \array_all($iterable, $callback);
}


/**
 * Fill an array with values, specifying keys using an iterator.
 *
 * Fills an array with the value of the **value** parameter, using the values
 * from the **keys** iterable as keys.
 *
 * @template K of array-key
 * @template V
 *
 * @param  iterable<array-key, K>  $keys
 *   Iterable of values that will be used as keys. Illegal values for key
 *   will be converted to `string`.
 *
 * @param  V  $value
 *   Value to use for filling.
 *
 * @return array<K, V>
 *   Returns the filled array.
 */
function fill_keys(iterable $keys, mixed $value): array
{
    if ($keys instanceof Traversable) {
        $keys = \iterator_to_array($keys);
    }

    return \array_fill_keys($keys, $value);
}

/**
 * @template V
 *
 * @param  V  ...$values
 * @return ArrayMap<array-key, V>
 */
function map(mixed ...$values): ArrayMap
{
    return new ArrayMap(...$values);
}
