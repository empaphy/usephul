<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul;

use empaphy\usephul\Var\Type;
use Generator;
use JetBrains\PhpStorm\Pure;

use function array_filter;
use function array_is_list;
use function array_map;
use function array_values;
use function in_array;
use function is_int;
use function is_string;

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
 * Retrieve an element from an array that can be located several levels deep.
 *
 * For example:
 *
 *     $data = [
 *         'foo' => [
 *             'bar' => [
 *                 'baz' => 'BAZ',
 *                 'qux' => ['QUX']
 *             ]
 *         ]
 *     ];
 *
 *     array_get($data, 'foo', 'bar', 'baz');    // Returns 'BAZ'
 *     array_get($data, 'foo', 'bar', 'qux');    // Returns ['QUX']
 *     array_get($data, 'foo', 'bar', 'qux', 0); // Returns 'QUX'
 *     array_get($data, 'foo', 'bar');           // Returns $data['foo']['bar']
 *     array_get($data, 'foo');                  // Returns $data['foo']
 *     array_get($data);                         // Returns $data
 *
 * @template TArray of array
 *
 * @param  TArray  $array
 *   The array to retrieve the element from.
 *
 * @param  string  ...$keys
 *   You can provide a path of keys, where each successive key should be a
 *   key on the value of the previous key.
 *
 * @return ($keys is empty ? TArray : mixed)
 *   Returns the value of the desired element, or `null` if it's not found.
 *   If no _keys_ are provided, __array__ is returned.
 */
function array_get(array $array, string|int ...$keys): mixed
{
    foreach ($keys as $key) {
        $array = $array[$key];
    }

    return $array;
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
 * @param  TKey  $key1
 * @param  TKey  $key2
 * @return array<TKey, TValue>
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
 * Inspects the types of keys used in an array.
 *
 * @param  array<int|string, mixed>  $array
 *   The array to inspect.
 *
 * @return ($array is array{}              ? array{}
 *       : ($array is array<int, mixed>    ? array{integer: true}
 *       : ($array is array<string, mixed> ? array{string: true}
 *       :                                   array{integer: true, string: true}
 *   )))
 *   Returns an array whose keys are strings representing the {@see Type types}
 *   of keys used in __array__. The values are always `true`.
 */
function array_key_types(array $array): array
{
    if (empty($array)) {
        return [];
    }

    if (array_is_list($array)) {
        return [Type::INTEGER => true];
    }

    $hasInt    = false;
    $hasString = false;
    foreach ($array as $key => $_) {
        if (is_int($key)) {
            if ($hasString) {
                return [Type::INTEGER => true, Type::STRING => true];
            }
            $hasInt = true;
        } elseif (is_string($key)) {
            if ($hasInt) {
                return [Type::INTEGER => true, Type::STRING => true];
            }
            $hasString = true;
        }
    }

    return match (true) {
        $hasInt    => [Type::INTEGER => true],
        $hasString => [Type::STRING  => true],
        default    => [],
    };
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
 * Split an array by a value.
 *
 * Returns a list of arrays, each of which is a subset of __array__ formed by
 * splitting it on boundaries formed by the value __separator__.
 *
 * Keys are preserved in the resulting arrays.
 *
 * > __Note__:
 * >
 * > For the ordering of the elements, PHP's array iteration order is used.
 *
 * @template TKey of array-key
 * @template TValue
 * @template TArray of array<TKey, TValue>
 *
 * @param  TArray  $array
 *   The input array.
 *
 * @param  TValue  $separator
 *   The boundary value.
 *
 * @param  int  $limit
 *   If __limit__ is set and positive, the returned list will contain a maximum
 *   of __limit__ arrays with the last array containing the rest of __array__.
 *
 *   If the __limit__ parameter is negative, all arrays except the last
 *   -__limit__ are returned.
 *
 *   If the __limit__ parameter is zero, then this is treated as 1.
 *
 * @param  bool  $strict
 *   By default {@see array_split()} will use strict comparisons (`===`) to
 *   match __separator__ against the values of __array__. If __strict__ is
 *   set to `false`, then non-strict comparisons (`==`) will be used instead.
 *
 * @return ($array is empty ? ($limit is negative-int ? list{} : list<TArray>)
 * : ($limit is int<1,1> ? list<TArray> : array<array-key, mixed>[]))
 *   Returns a list of arrays created by splitting the __array__ parameter on
 *   boundaries formed by the __separator__.
 *
 *   If __separator__ contains a value not contained in __array__ and
 *   a negative __limit__ is used, then an empty list will be returned,
 *   otherwise a list containing __array__ will be returned. If __separator__
 *   values appear at the start or end of __array__, said values will be added
 *   as an empty array either in the first or last position of the returned
 *   list respectively.
 *
 * @noinspection SuspiciousBinaryOperationInspection
 * @noinspection TypeUnsafeComparisonInspection
 */
function array_split(
    array $array,
    mixed $separator,
    int   $limit  = PHP_INT_MAX,
    bool  $strict = true,
): array {
    if (0 === $limit) {
        $limit = 1;
    } elseif ($limit < 0) {
        foreach ($array as $value) {
            if (! $strict && $value == $separator || $value === $separator) {
                $limit++;
            }
        }
        $limit++;

        if ($limit <= 0) {
            return [];
        }

        $limit = -$limit;
    }

    $list = [];
    $item = [];

    foreach ($array as $key => $value) {
        if (
            (! $strict && $value == $separator || $value === $separator)
            && ($limit > 1 || $limit < 0)
        ) {
            $list[] = $item;
            $item = [];
            $limit > 1 ? $limit-- : $limit++;
        } else {
            $item[$key] = $value;
        }

        if (0 === $limit) {
            return $list;
        }
    }

    $list[] = $item;

    return $list;
}

/**
 * Perform a zip operation on multiple arrays.
 *
 * @param  array<array-key, mixed>  $array
 *   An array to zip.
 *
 * @param  array<array-key, mixed>  ...$arrays
 *   Supplementary list of array arguments to zip.
 *
 * @return list<list<mixed>>
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
