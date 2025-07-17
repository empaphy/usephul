<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul;

use Generator;

use function array_filter;
use function array_is_list;
use function array_map;
use function array_values;
use function in_array;

/**
 * Exclude from an array all the elements that match the provided values.
 *
 * @template TValue
 *
 * @param  array<array-key,TValue>  $array
 *   The input array.
 *
 * @param  TValue  ...$values
 *   The values to be excluded from __array__.
 *
 * @return array<array-key,mixed>
 *   Returns a new array containing all the elements in __array__ except for
 *   those with values present in __values__.
 *
 * @see array_extract() - Extract values from an array
 * @see array_omit() - Omit keys from an array
 * @see array_pick() - Pick keys from an array
 */
function array_exclude(array $array, mixed ...$values): array
{
    $result = array_filter(
        $array,
        static fn(mixed $value): bool => ! in_array($value, $values, true),
    );

    return array_is_list($array) ? array_values($result) : $result;
}

/**
 * Extract from an array all the elements of the input array matching the
 * provided values.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param  array<TKey,TValue>  $array
 *   The input array.
 *
 * @param  TValue  ...$values
 *   The values to be extracted from __array__.
 *
 * @return array<TKey,TValue>
 *   Returns an array containing all the elements from __array__ that are also
 *   present in __values__.
 *
 * @see array_exclude() - Exclude values from an array
 * @see array_omit() - Omit keys from an array
 * @see array_pick() - Pick keys from an array
 */
function array_extract(array $array, mixed ...$values): array
{
    $result = array_filter(
        $array,
        static fn(mixed $value): bool => in_array($value, $values, true),
    );

    return array_is_list($array) ? array_values($result) : $result;
}

/**
 * Interchange the values of two elements in an array.
 *
 * If either of the keys doesn't exist in __array__, then the other key will
 * be set to `null`, and a PHP Warning will be emitted.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param  array<TKey, TValue>  $array
 * @param  TKey                 $key1
 * @param  TKey                 $key2
 * @return array<TKey, TValue>
 *
 * @noinspection PhpDocSignatureInspection
 */
function array_interchange(array $array, int|string $key1, int|string $key2): array
{
    return [
        ...$array,
        $key1 => $array[$key2],
        $key2 => $array[$key1],
    ];
}

/**
 * Create a copy of the input array while omiting specific keys.
 *
 * @template TKey of array-key
 *
 * @param  array<TKey,mixed>  $array
 *   The input array.
 *
 * @param  TKey  ...$keys
 *   The keys of the elements to be omitted from __array__.
 *
 * @return array<array-key,mixed>
 *   Returns a new array containing all the elements in __array__ except for
 *   those with keys present in __keys__.
 *
 * @see array_exclude() - Exclude values from an array
 * @see array_extract() - Extract values from an array
 * @see array_pick() - Pick keys from an array
 */
function array_omit(array $array, int|string ...$keys): array
{
    foreach ($keys as $key) {
        // Retrieving $array[$key] here just to ensure a Warning is emitted
        // if it isn't set.
        $value = $array[$key];
        unset($value, $array[$key]);
    }

    return $array;
}

/**
 * Create a new array by picking elements from the input array corresponding
 * to a specific set of keys.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param  array<TKey,TValue>  $array
 *   The input array.
 *
 * @param  TKey  ...$keys
 *   The keys of the elements to pick from __array__.
 *
 * @return array<TKey,TValue>
 *   Returns a new array consisting of the elements with keys matching __keys__.
 *
 * @see array_exclude() - Exclude values from an array
 * @see array_extract() - Extract values from an array
 * @see array_omit() - Omit keys from an array
 */
function array_pick(array $array, int|string ...$keys): array
{
    $picked = [];
    foreach ($keys as $key) {
        $picked[$key] = $array[$key];
    }

    return $picked;
}

/**
 * Applies a (generator) callback to the elements of a given array, allowing
 * the remapping of its keys in the process.
 *
 * {@see array_remap()} returns an {@link https://php.net/array array}
 * containing the results of applying a __callback__ with the corresponding
 * key and value of __array__ used as arguments.
 *
 * If __callback__ is a {@link https://php.net/generator generator}
 * function, then it's possible to provide a new key for the resulting array
 * element using `yield from $key => $value`.
 *
 * If the same key is yielded more than once, then the later yield will
 * override the previous one.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param  callable(TKey $key, TValue $value): mixed  $callback
 *   A callable to run for each key-value pair in the array.
 *
 * @param  array<TKey, TValue>  $array
 *   An array to run through the callback (generator) function.
 *
 * @return array
 *   Returns an array containing the results of applying the __callback__
 *   function to the corresponding key-value pair of __array__ used as
 *   arguments for the callback.
*/
function array_remap(callable $callback, array $array): array
{
    return [...(
        static function (array $array) use ($callback) {
            foreach ($array as $key => $value) {
                $result = $callback($key, $value);

                if ($result instanceof Generator) {
                    yield from $result;
                } else {
                    yield $key => $result;
                }
            }
        }
    )($array)];
}

/**
 * Perform a zip operation on multiple arrays.
 *
 * @template TValue
 *
 * @param  array<array-key, TValue>  $array
 *   An array to zip.
 *
 * @param  array<array-key, TValue>  ...$arrays
 *   Supplementary list of array arguments to zip.
 *
 * @return list<array{TValue}>
 *   Returns an array whose elements are each an array holding the elements
 *   of the input arrays at the same index.
 */
function array_zip(array $array, array ...$arrays): array
{
    if (empty($arrays)) {
        $zipped = [];

        foreach ($array as $value) {
            $zipped[] = [$value];
        }

        return $zipped;
    }

    return array_map(null, $array, ...$arrays);
}
