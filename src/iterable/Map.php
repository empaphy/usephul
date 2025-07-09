<?php

declare(strict_types=1);

namespace empaphy\usephul\iterable;

/**
 * Maps keys to values.
 *
 * A map cannot contain duplicate keys; each key can map to at most one value.
 *
 * @template TKey of array-key
 * @template TValue
 */
interface Map extends \Countable, \ArrayAccess
{
    public function isEmpty(): bool;

    /**
     * Checks if a value exists in this Map.
     *
     * Searches for **needle** in this {@see Map} using loose comparison unless
     * **strict** is set.
     *
     * @param  mixed  $needle
     *   The searched value.
     *
     *   > **Note**:
     *   >
     *   > If **needle** is a string, the comparison is done in a case-sensitive
     *   > manner.
     *
     * @param  bool  $strict
     *   If the third parameter **strict** is set to `true` then the
     *   {@see ArrayMap::contains()} function will also check the
     *   {@link https://php.net/types types} of the needle in this {@see Map}.
     *
     * @return bool
     *   Returns `true` if **needle** is found in this {@see Map}, `false`
     *   otherwise.
     */
    public function contains(mixed $needle, bool $strict = false): bool;

    /**
     * Return all the keys or a subset of the keys of this Map.
     *
     * {@see ArrayMap::keys()} returns the keys, numeric and string, from this Map.
     *
     * If a **filterValue** is specified, then only the keys for that value
     * are returned. Otherwise, all the keys from this {@see Map} are returned.
     *
     * @param  mixed|null  $filterValue
     *   If specified, then only keys containing this value are returned.
     *
     * @param  bool  $strict
     *   Determines if strict comparison (===) should be used during the search.
     *
     * @return Collection<TValue>
     *   Returns a new {@see Map} of all the keys in this {@see Map}.
     */
    public function keys(
        mixed $filterValue = null,
        bool $strict = false
    ): Collection;

    public function values(): Collection;

    /**
     * Merge one or more iterables into this Map.
     *
     * Merges the elements of one or more iterables into this {@see Map} so
     * that the values of one are appended to the end of the previous one.
     *
     * If the **iterables** have the same string keys, then the later value
     * for that key will overwrite the previous one. If, however, the iterables
     * contain numeric keys, the later value will not overwrite the original
     * value, but will be appended.
     *
     * Values in the input iterables with numeric keys will be renumbered with
     * incrementing keys starting from zero in the result {@see Map}.
     *
     * @template K of array-key
     * @template V
     *
     * @param  iterable<K, V>  ...$iterables
     *   Variable list of iterables to merge.
     *
     * @return static<TKey|K, TValue|V>
     *   Returns the resulting {@see Map}.
     */
    public function merge(iterable ...$iterables): static;
}
