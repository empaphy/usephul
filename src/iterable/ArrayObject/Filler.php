<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable\ArrayObject;

use ArrayObject;
use Traversable;
use function array_fill;
use function array_fill_keys;
use function iterator_to_array;
use function range;

/**
 * Provides static methods that generate a filled ArrayObject.
 *
 * @template TKey
 * @template TValue
 */
trait Filler
{
    /**
     * Fill an ArrayObject with values.
     *
     * Fills a {@see static} with **count** entries of the value of the **value**
     * parameter, keys starting at the **startIndex** parameter.
     *
     * @template V
     *
     * @param  int  $startIndex
     *   The first index of the returned {@see static}.
     *
     * @param  non-negative-int  $count
     *   Number of elements to insert. Must be greater than or equal to zero,
     *   and less than or equal to `2147483647`.
     *
     * @param  V  $value
     *   Value to use for filling.
     *
     * @return static<int, V>
     *   Returns the filled {@see static}.
     */
    public static function fill(
        int $startIndex,
        int $count,
        mixed $value
    ): static {
        return static::fromArray(array_fill($startIndex, $count, $value));
    }

    /**
     * Fill a Map with values, specifying keys.
     *
     * Fills a {@see ArrayMap} with the value of the **value** parameter, using the
     * values of the **keys** iterable as keys.
     *
     * @template K of array-key
     * @template V
     *
     * @param  iterable<array-key, K>  $keys
     *   Iterable of values that will be used as keys. Illegal values for key
     *   will be converted to {@link https://php.net/string string}.
     *
     * @param  V  $value
     *   Value to use for filling.
     *
     * @return static<K, V>
     *   Returns the filled {@see ArrayMap}.
     */
    public static function fillKeys(iterable $keys, mixed $value): static
    {
        /** @noinspection NestedTernaryOperatorInspection */
        return static::fromArray(
            array_fill_keys(
                $keys instanceof ArrayObject ? $keys->getArrayCopy() : (
                    $keys instanceof Traversable
                        ? iterator_to_array($keys)
                        : $keys
                ),
                $value
            )
        );
    }

    /**
     * Create a Map containing a range of elements.
     *
     * If both **start** and **end** are `string`s, and **step** is `int` the
     * produced {@see ArrayMap} will be a sequence of bytes. Otherwise, the produced
     * {@see ArrayMap} will be a sequence of numbers.
     *
     * The sequence is increasing if **start** is less than equal to **end**.
     * Otherwise, the sequence is decreasing.
     *
     * @template V of string|int|float
     *
     * @param  V  $start
     *   First value of the sequence.
     *
     * @param  V  $end
     *   Last possible value of the sequence.
     *
     * @param  int|float  $step
     *   **step** indicates by how much the produced sequence is progressed
     *   between values of the sequence.
     *
     *   **step** may be negative for decreasing sequences.
     *
     *   If **step** is a `float` without a fractional part, it is interpreted
     *   as `int`.
     *
     * @return static<int, V>
     *   Returns a sequence of elements as a {@see ArrayMap} with the first element
     *   being **start** going up to **end**, with each value of the sequence
     *   being **step** values apart.
     *
     *   The last element of the returned {@see ArrayMap} is either **end** or the
     *   previous element of the sequence, depending on the value of **step**.
     *
     *   If both **start** and **end** are `string`s, and **step** is `int`
     *   the produced {@see ArrayMap} will be a sequence of bytes, generally latin
     *   ASCII characters.
     *
     *   If at least one of **start**, **end**, or **step** is `float` the
     *   produced array will be a sequence of `float`.
     *
     *   Otherwise, the produced array will be a sequence of `int`.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public static function range(
        string|int|float $start,
        string|int|float $end,
        int|float $step = 1
    ): static {
        return static::fromArray(range($start, $end, $step));
    }
}
