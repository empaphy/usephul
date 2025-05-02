<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * Applies a (generator) callback to the elements of a given array, allowing the
 * remapping of its keys in the process.
 *
 * {@see array_remap()} returns an {@link https://php.net/array array}
 * containing the results of applying a **callback** with the corresponding key
 * and value of **array** used as arguments.
 *
 * If **callback** is a {@link https://php.net/generator generator} function,
 * then it's possible to provide a new key for the resulting array element using
 * `yield from $key => $value`.
 *
 * If the same key is yielded more than once, then the later yield will override
 * the previous one.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param  callable(TKey $key, TValue $value): mixed  $callback
 *           A callable to run for each key-value pair in the array.
 * @param  array<TKey, TValue>  $array
 *           An array to run through the callback (generator) function.
 * @return array
 *           Returns an array containing the results of applying the
 *           **callback** function to the corresponding key-value pair of
 *           **array** used as arguments for the callback.
*/
function array_remap(callable $callback, array $array): array
{
    return [...(
        static function (array $array) use ($callback) {
            foreach ($array as $key => $value) {
                $result = $callback($key, $value);

                if ($result instanceof \Generator) {
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
 * @param  array<TValue>  $array      An array to zip.
 * @param  array<TValue>  ...$arrays  Supplementary list of array arguments to
 *                                    zip.
 * @return array<array<TValue>> Returns an array whose elements are each an
 *                              array holding the elements of the input arrays
 *                              of the same index.
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

    return \array_map(null, $array, ...$arrays);
}
