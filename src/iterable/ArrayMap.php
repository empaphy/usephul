<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 *
 * @noinspection NestedTernaryOperatorInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable;

use ArrayIterator;
use ArrayObject;
use empaphy\usephul\iterable\ArrayObject\Filler;
use empaphy\usephul\iterable\ArrayObject\Filter;
use Traversable;
use function iterator_to_array;

// All the imports below are in the same order as that they appear in `array.c`

use function krsort;
use function ksort;

use function count;

use function natsort;
use function natcasesort;
use function asort;
use function arsort;
use function sort;
use function rsort;
use function usort;
use function uasort;
use function uksort;

use function end;
use function prev;
use function next;
use function reset;
use function current;
use function key;

use function min;
use function max;

use function array_walk;
use function array_walk_recursive;
use function in_array;
use function array_search;

use function extract;
use function compact;

use function shuffle;

use function array_push;
use function array_pop;
use function array_shift;
use function array_unshift;
use function array_splice;
use function array_slice;
use function array_merge;
use function array_merge_recursive;
use function array_replace;
use function array_replace_recursive;

use function array_keys;
use function array_key_first;
use function array_key_last;
use function array_values;
use function array_count_values;

use function array_column;
use function array_reverse;
use function array_pad;
use function array_flip;
use function array_change_key_case;
use function array_unique;

// intersection / diff
use function array_intersect_key;
use function array_intersect_ukey;
use function array_intersect;
use function array_uintersect;
use function array_intersect_assoc;
use function array_intersect_uassoc;
use function array_uintersect_assoc;
use function array_uintersect_uassoc;
use function array_diff_key;
use function array_diff_ukey;
use function array_diff;
use function array_udiff;
use function array_diff_assoc;
use function array_diff_uassoc;
use function array_udiff_assoc;
use function array_udiff_uassoc;

use function array_multisort;

// math stuff
use function array_rand;
use function array_sum;
use function array_product;
use function array_reduce;

// ArrayObjectFinder
use function array_filter;
use function array_find;
use function array_find_key;
use function array_any;
use function array_all;
use function array_map;
use function array_key_exists;

// Chunking
use function array_chunk;
use function array_combine;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @use Filler<TKey, TValue>
 * @use Filter<TKey, TValue>
 * @implements Filterable<TKey, TValue>
 * @implements Stack<TValue>
 * @extends ArrayObject<TKey, TValue>
 */
class ArrayMap extends ArrayObject implements Filterable, Stack
{
    use Filler;
    use Filter;

    /**
     * Properties of the object have their normal functionality when accessed
     * as  list (var_dump(), foreach, etc.).
     */
    public const FLAG_STD_PROP_LIST = parent::STD_PROP_LIST;

    /**
     * Entries can be accessed as properties (read and write).
     *
     * The {@see Map} class uses its own logic to access properties, thus no
     * warning or error is raised when trying to read or write dynamic
     * properties.
     */
    public const FLAG_ARRAY_AS_PROPS = parent::ARRAY_AS_PROPS;

    /**
     * Construct a new Map.
     *
     * This constructs a new {@see Map}.
     *
     * @param  iterable<TKey, TValue>           $array
     *   The **array** parameter accepts an {@link https://php.net/array array}.
     *
     * @param  int-mask-of<self::FLAG_*>     $flags
     *   Flags to control the behaviour of the {@see Map}.
     *
     * @param  class-string<ArrayIterator>  $iteratorClass
     *   Specify the class that will be used for iteration of the {@see Map}.
     */
    public function __construct(
        iterable  $array = [],
        int       $flags = 0,
        string    $iteratorClass = ArrayIterator::class,
    ) {
        parent::__construct(
            $array instanceof ArrayObject ? $array->getArrayCopy() : (
                $array instanceof Traversable
                    ? iterator_to_array($array)
                    : $array
            ),
            $flags,
            $iteratorClass
        );
    }

    /**
     * Changes the case of all keys.
     *
     * Returns a {@see Map} with all keys lowercased or uppercased. Numbered
     * indices are left as is.
     *
     * @param  KeyCase  $case
     *   Either {@see KeyCase::Upper} or {@see KeyCase::Lower} (default)
     *
     * @return static<TKey, TValue>
     *   Returns a {@see Map} with its keys lower or uppercased.
     */
    public function changeKeyCase(KeyCase $case = KeyCase::Lower): static
    {
        return $this->withArray(
            array_change_key_case($this->getArrayCopy(), $case->value)
        );
    }

    /**
     * Split this Map into chunks.
     *
     * Chunks this {@see Map} into Maps with **length** elements. The last
     * chunk may contain less than **length** elements.
     *
     * @param  positive-int  $length
     *   The size of each chunk.
     *
     * @param  bool  $preserveKeys
     *   When set to `true` keys will be preserved. Default is `false` which
     *   will reindex the chunk numerically.
     *
     * @return static<TKey, TValue>[]
     *   Returns a numerically indexed array, starting with zero, with each
     *   element containing a {@see Map} of **length** elements.
     *
     * @throws \ValueError if length is less than `1`.
     */
    public function chunk(int $length, bool $preserveKeys = false): array
    {
        $chunks = [];

        foreach (
            array_chunk($this->getArrayCopy(), $length, $preserveKeys)
            as $key => $chunk
        ) {
            $chunks[$key] = $this->withArray($chunk);
        }

        return $chunks;
    }

    /**
     * Return the values from a single column.
     *
     * {@see ArrayMap::column()} returns the values from a single column of this
     * {@see Map}, identified by the **columnKey**. Optionally, an **indexKey**
     * may be provided to index the values in the returned {@see Map} by the
     * values from the **indexKey** column of this {@see Map}.
     *
     * @param  int|string|null  $columnKey
     *   The column of values to return. This value may be an integer key of
     *   the column you wish to retrieve, or it may be a string key name. It
     *   may also be `null` to return complete Maps (this is useful together
     *   with **indexKey** to reindex the {@see Map}).
     *
     * @param  int|string|null  $indexKey
     *   The column to use as the index/keys for the returned {@see Map}. The
     *   value is
     *   {@link https://php.net/array#language.types.array.key-casts cast} as
     *   usual for {@see Map} keys.
     *
     * @return static
     *   Returns a new {@see Map} of values representing a single column from
     *   this {@see Map}.
     */
    public function column(
        int|string|null $columnKey,
        int|string|null $indexKey = null,
    ): static {
        return static::fromArray(
            array_column($this->getArrayCopy(), $columnKey, $indexKey)
        );
    }

    /**
     * Counts the occurences of each distinct value.
     *
     * {@see ArrayMap::countValues()} returns a new {@see Map} using the values of
     * this {@see Map} (which must be ints or strings) as keys and their
     * frequency as values.
     *
     * @return (TValue is array-key? static<TValue,int> : static<array-key,int>)
     *   Returns a new {@see Map} with values from this {@see Map} as keys
     *   and their count as value.
     */
    public function countValues(): static
    {
        return static::fromArray(
            array_count_values($this->getArrayCopy())
        );
    }

    /**
     * Computes the difference of this Map to given iterables.
     *
     * Compares this {@see Map} against one or more **iterables** and returns
     * the values in this {@see Map} that are not present in any of the
     * **iterables**.
     *
     * @param  iterable  ...$iterables
     *   Iterab;es to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the entries from this
     *   {@see Map} that are not present in any of the **iterables**. Keys
     *   in the {@see Map} are preserved.
     */
    public function diff(iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(array_diff($this->getArrayCopy(), ...$iterables));
    }

    /**
     * Computes the difference of iterables with additional index check.
     *
     * Compares this {@see Map} against **iterables** and returns the
     * difference. Unlike {@see ArrayMap::diff()} the iterables keys are also used
     * in the comparison.
     *
     * @param  iterable  ...$iterables
     *   Iterables to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the values from this {@see Map}
     *   that are not present in any of the **iterables**.
     */
    public function diffAssoc(iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_diff_assoc($this->getArrayCopy(), ...$iterables)
        );
    }

    /**
     * Computes the difference of this Map to **iterables** using keys for
     * comparison.
     *
     * Compares the keys from this {@see Map} against the keys from
     * **iterables** and returns the difference. This method is like
     * {@see ArrayMap::diff()} except the comparison is done on the keys instead
     * of the values.
     *
     * @param  iterable  ...$iterables
     *   Iterables to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a {@see Map} containing all the entries from this {@see Map}
     *   whose keys are absent from all the other iterables.
     */
    public function diffKey(iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_diff_key($this->getArrayCopy(), ...$iterables)
        );
    }

    /**
     * Computes the difference of this Map to given iterables with additional
     * index check which is performed by a user supplied callback function.
     *
     * Compares this {@see Map} against **iterables** and returns the
     * difference. Unlike {@see ArrayMap::diff()} the iterable keys are used in the
     * comparison.
     *
     * Unlike {@see ArrayMap::diffAssoc()} a user supplied callback function is
     * used for the indices comparison, not internal function.
     *
     * @template K of array-key
     * @template V
     *
     * @param  callback(TKey $a, K $b): int  $keyCompareFunc
     *   The comparison function must return an integer less than, equal to,
     *   or greater than zero if the first argument is considered to be
     *   respectively less than, equal to, or greater than the second.
     *
     *   > **Caution**
     *   > Returning _non-integer_ values from the comparison function, such
     *   > as {@link https://php.net/float float}, will result in an internal
     *   > cast to {@link https://php.net/int int} of the callback's return
     *   > value. So values such as `0.99` and `0.1` will both be cast to an
     *   > integer value of `0`, which will compare such values as equal.
     *
     * @param  iterable<K, V>  ...$iterables
     *   Iterables to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a {@see Map} containing all the entries from this {@see Map}
     *   that are not present in any of the **iterables**.
     */
    public function diffUAssoc(
        callable $keyCompareFunc,
        iterable ...$iterables
    ): static {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_diff_uassoc(
                $this->getArrayCopy(),
                ...[...$iterables, $keyCompareFunc]
            )
        );
    }

    /**
     * Computes the difference of this Map to given iterables using a callback
     * function on the keys for comparison.
     *
     * Compares the keys from this {@see Map} against the keys from
     * **iterables** and returns the difference. This method is like
     * {@see ArrayMap::diff()} except the comparison is done on the keys instead
     * of the values.
     *
     * Unlike {@see ArrayMap::diffKey()} a user supplied callback function is used
     * for the indices comparison, not internal function.
     *
     * @template K of array-key
     * @template V
     *
     * @param  callback(TKey $a, K $b): int  $keyCompareFunc
     *   The comparison function must return an integer less than, equal to,
     *   or greater than zero if the first argument is considered to be
     *   respectively less than, equal to, or greater than the second.
     *
     *   > **Caution**
     *   > Returning _non-integer_ values from the comparison function, such
     *   > as {@link https://php.net/float float}, will result in an internal
     *   > cast to {@link https://php.net/int int} of the callback's return
     *   > value. So values such as `0.99` and `0.1` will both be cast to an
     *   > integer value of `0`, which will compare such values as equal.
     *
     * @param  iterable<K, V>  ...$iterables
     *   Iterables to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a {@see Map} containing all the entries from this {@see Map}
     *   that are not present in any of the **iterables**.
     */
    public function diffUKey(
        callable $keyCompareFunc,
        iterable ...$iterables
    ): static {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_diff_ukey(
                $this->getArrayCopy(),
                ...[...$iterables, $keyCompareFunc]
            )
        );
    }

    /**
     * Exchanges all keys with their associated values.
     *
     * {@see ArrayMap::flip()} returns a new {@see Map} in flip order, i.e. keys
     * from this {@see Map} become values and values from this {@see Map}
     * become keys.
     *
     * Note that the values of this {@see Map} need to be valid keys, i.e.
     * they need to be either {@link https://php.net/int int} or
     * {@link https://php.net/string string}. A warning will be emitted if a
     * value has the wrong type, and the key/value pair in question _will not
     * be included in the result_.
     *
     * If a value has several occurrences, the latest key will be used as its
     * value, and all others will be lost.
     *
     * @return (
     *     TValue is array-key ? static<TValue, TKey> : static<array-key, TKey>
     * ) Returns the flipped array.
     */
    public function flip(): static
    {
        return $this->withArray(array_flip($this->getArrayCopy()));
    }

    /**
     * Computes the intersection of this Map with given arrays.
     *
     * {@see ArrayMap::intersect()} returns a new {@see Map} containing all the
     * values of this {@see Map} that are present in all the arguments. Note
     * that keys are preserved.
     *
     * @param  iterable  ...$iterables
     *   Iterables to compare values against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the values in this {@see Map}
     *   whose values exist in all the parameters.
     */
    public function intersect(iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_intersect($this->getArrayCopy(), ...$iterables)
        );
    }

    /**
     * Computes the intersection of this Map with given iterables with
     * additional index check.
     *
     * {@see ArrayMap::intersectAssoc()} returns a new {@see Map} containing all
     * the values of this {@see Map} that are present in all the arguments.
     * Note that the keys are also used in the comparison unlike in
     * {@see ArrayMap::intersect()}.
     *
     * @param  iterable  ...$iterables
     *   Iterables to compare values against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the values in this {@see Map}
     *   that are present in all the arguments.
     */
    public function intersectAssoc(iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_intersect_assoc($this->getArrayCopy(), ...$iterables)
        );
    }

    /**
     * Checks whether this Map is a list.
     *
     * Determines if this {@see Map} is a list. It is considered a list if
     * its keys consist of consecutive numbers from `0` to `count($array)-1`.
     *
     * @return bool
     *   Returns `true` if this {@see Map} is a list, `false` otherwise.
     */
    public function isList(): bool
    {
        return array_is_list($this->getArrayCopy());
    }

    /**
     * Checks if the given key or index exists in this Map.
     *
     * {@see ArrayMap::keyExists()} returns `true` if the given **key** is set in
     * this {@see Map}. **key** can be any value possible for an array index.
     *
     * > **Note**:
     * >
     * > {@see ArrayMap::keyExists()} will search for the keys in the first dimension
     * > only. Nested keys in multidimensional Maps will not be found.
     *
     * @param  TKey  $key
     *   Value to check.
     *
     * @return bool
     *   Returns true on success or false on failure.
     *
     * @phpstan-assert-if-true TValue $this[$key]
     */
    public function keyExists(mixed $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * Gets the first key of this Map.
     *
     * Get the first key of this Map without affecting the internal pointer.
     *
     * @return array-key | null
     *   Returns the first key of this Map if it's not empty; `null` otherwise.
     */
    public function firstKey(): int|string|null
    {
        return array_key_first($this->getArrayCopy());
    }

    /**
     * Gets the last key of this Map.
     *
     * Get the last key of this Map without affecting the internal pointer.
     *
     * @return array-key | null
     *   Returns the last key of this Map if it's not empty; `null` otherwise.
     */
    public function lastKey(): int|string|null
    {
        return array_key_last($this->getArrayCopy());
    }

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
     * @return static
     *   Returns a new {@see Map} of all the keys in this {@see Map}.
     */
    public function keys(
        mixed $filterValue = null,
        bool $strict = false
    ): static {
        if (func_num_args() === 0) {
            return static::fromArray(array_keys($this->getArrayCopy()));
        }

        return static::fromArray(
            array_keys($this->getArrayCopy(), $filterValue, $strict)
        );
    }

    /**
     * Applies the callback to the elements of this Map.
     *
     * {@see ArrayMap::map()} returns a new {@see Map} containing the results of
     * applying the **callback** to the corresponding value of this {@see Map}
     * used as arguments for the callback.
     *
     * @param  callable(TValue $value): mixed  $callback
     *   A callable to run for each element in this {@see Map}.
     *
     * @return static
     *   Returns a new {@see Map} containing the results of applying the
     *   **callback** function to the corresponding value of this {@see Map}
     *   used as arguments for the callback.
     *
     *   The new {@see Map} will preserve the keys of this {@see Map}.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public function map(?callable $callback): static
    {
        return $this->withArray(array_map($callback, $this->getArrayCopy()));
    }

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
    public function merge(iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        return $this->withArray(
            array_merge($this->getArrayCopy(), ...$iterables)
        );
    }

    /**
     * Pad this Map to the specified length with a value.
     *
     * {@see ArrayMap::pad()} returns a copy of this {@see Map} padded to size
     * specified by **length** with value **value**. If **length** is positive
     * then the {@see Map} is padded on the right, if it's negative then on
     * the left. If the absolute value of **length** is less than or equal to
     * the length of this {@see Map} then no padding takes place.
     *
     * @template V
     *
     * @param  int  $length
     *   Size of the new {@see Map}.
     *
     * @param  V  $value
     *   Value to pad if this {@see Map} is smaller than **length**.
     *
     * @return static<TKey|int, TValue|V>
     *   Returns a copy of the array padded to size specified by **length**
     *   with value **value**. If **length** is positive then the array is
     *   padded on the right, if it's negative then on the left. If the absolute
     *   value of **length** is less than or equal to the length of this
     *   {@see Map} then no padding takes place.
     */
    public function pad(int $length, mixed $value): static
    {
        return $this->withArray(
            array_pad($this->getArrayCopy(), $length, $value)
        );
    }

    /**
     * Pop the element off the end of this {@see Map}.
     *
     * {@see ArrayMap::pop()} pops and returns the value of the last element of
     * this {@see Map}, shortening the {@see Map} by one element.
     *
     * > **Note**:
     * >
     * > This function will {@see ArrayMap::reset()} the pointer of this {@see Map}
     * > after use.
     *
     * @return TValue|null
     *   Returns the value of the last element of this {@see Map}. If this
     *   {@see Map} is empty, `null` will be returned.
     */
    public function pop(): mixed
    {
        $array = $this->getArrayCopy();
        if (empty($array)) {
            return null;
        }

        $lastKey = array_key_last($array);
        $result = $this->offsetGet($lastKey);
        $this->offsetUnset($lastKey);
        $this->getIterator()->rewind();

        return $result;
    }

    /**
     * Calculate the product of values in this Map.
     *
     * {@see ArrayMap::product()} returns the product of values in this {@see Map}.
     *
     * @return int|float
     *   Returns the product as an integer or float.
     */
    public function product(): int|float
    {
        return array_product($this->getArrayCopy());
    }

    /**
     * Push one or more elements onto the end of this Map.
     *
     * {@see ArrayMap::push()} treats this {@see Map} as a stack, and pushes the
     * passed variables onto the end of it. The length of this {@see Map}
     * increases by the number of variables pushed. Has the same effect as:
     *
     *     $array[] = $var;
     *
     * repeated for each passed value.
     *
     * @param  mixed  ...$values
     *   The values to push onto the end of the array.
     *
     * @return int
     *   Returns the new number of elements in the array.
     */
    public function push(mixed ...$values): int
    {
        foreach ($values as $value) {
            $this->append($value);
        }

        return $this->count();
    }

    /**
     * Pick one or more random keys out of this Map.
     *
     * Picks one or more random entries out of this {@see Map}, and returns
     * the key (or keys) of the random entries.
     *
     * > **Caution**
     * > This function does not generate cryptographically secure values, and
     * > _must not_ be used for cryptographic purposes, or purposes that require
     * > returned values to be unguessable.
     * >
     * > If cryptographically secure randomness is required, the
     * > {@link https://php.net/random-randomizer Random\Randomizer} may be
     * > used with the
     * > {@link https://php.net/random-engine-secure Random\Engine\Secure}
     * > engine. For simple use cases, the
     * > {@link https://php.net/random-int random_int()} and
     * > {@link https://php.net/random-bytes random_bytes()} functions provide
     * > a convenient and secure API that is backed by the operating system’s
     * > CSPRNG.
     *
     * @param  int  $num
     *   Specifies how many entries should be picked. Must be greater than
     *   zero, and less than or equal to the length of this {@see Map}.
     *
     * @return array-key|array-key[]
     *   When picking only one entry, {@see ArrayMap::rand()} returns the key for
     *   a random entry. Otherwise, an array of keys for the random entries
     *   is returned. This is done so that random keys can be picked from the
     *   array as well as random values. If multiple keys are returned, they
     *   will be returned in the order they were present in the original array.
     *
     * @throws \ValueError
     *   if this {@see Map} is empty, or if **num** is out of range.
     */
    public function rand(int $num = 1): int|string|array
    {
        return array_rand($this->getArrayCopy(), $num);
    }

    /**
     * Iteratively reduce this Map to a single value using a callback function.
     *
     * {@see ArrayMap::reduce()} applies iteratively the **callback** function to
     * the elements of this {@see Map}, to reduce it to a single value.
     *
     * @template I
     * @template C
     *
     * @param  callable(I|C $carry, TValue $item): C  $callback  <dl>
     *   <dt>**carry**</dt>
     *   <dd>
     *       Holds the return value of the previous iteration; in the case of
     *       the first iteration it instead holds the value of **initial**.
     *   </dd>
     *
     *   <dt>**item**</dt>
     *   <dd>
     *       Holds the value of the current iteration.
     *   </dd></dl>
     *
     * @param  I  $initial
     *   If the optional **initial** is available, it will be used at the
     *   beginning of the process, or as a final result in case the {@see Map}
     *   is empty.
     *
     * @return C
     *   Returns the resulting value.
     *
     *   If this {@see Map} is empty and **initial** is not passed,
     *   {@see ArrayMap::reduce()} returns `null`.
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->getArrayCopy(), $callback, $initial);
    }

    /**
     * Replaces elements from passed iterables into this Map.
     *
     * {@see ArrayMap::replace()} creates a new {@see Map} and assigns items into
     * it for each key in each of the provided iterables. If a key appears in
     * multiple input iterables, the value from the right-most input iterable
     * will be used.
     *
     * {@see ArrayMap::replace()} does not process elements items recursively, it
     * replaces the entire value for each key when it does a replacement.
     *
     * @template K of array-key
     * @template V
     *
     * @param  iterable<K, V>  ...$replacements
     *   Iterables from which elements will be extracted. Values from later
     *   iterables overwrite the previous values.
     *
     * @return static<TKey|K, TValue|V>
     *   Returns an array.
     */
    public function replace(iterable ...$replacements): static
    {
        foreach ($replacements as $key => $replacement) {
            if ($replacement instanceof ArrayObject) {
                $replacements[$key] = $replacement->getArrayCopy();
            } elseif ($replacement instanceof Traversable) {
                $replacements[$key] = iterator_to_array($replacement);
            }
        }

        return $this->withArray(
            array_replace($this->getArrayCopy())
        );
    }

    /**
     * Set the internal pointer of this Map to its first element.
     *
     * {@see ArrayMap::reset()} rewinds this {@see Map}'s internal pointer to the
     * first element and returns the value of the first array element.
     *
     * @return TValue|null
     *   Returns the value of the first array element, or `false` if the array
     *   is empty.
     *
     *   > **Warning**
     *   > This function may return Boolean false, but may also return a
     *   > non-Boolean value which evaluates to `false`. Please read the
     *   > section on {@link https://php.net/boolean Booleans} for more
     *   > information.
     */
    public function reset(): mixed
    {
        $iterator = $this->getIterator();
        $iterator->rewind();

        return $iterator->current();
    }

    /**
     * Return a new Map with elements in reverse order.
     *
     * Takes an input array and returns a new array with the order of the
     * elements reversed.
     *
     * @param  bool  $preserveKeys
     *   If set to `true` numeric keys are preserved. Non-numeric keys are
     *   not affected by this setting and will always be preserved.
     *
     * @return static<TKey, TValue>
     *   Returns a reversed {@see Map}.
     */
    public function reverse(bool $preserveKeys = false): static
    {
        return $this->withArray(
            array_reverse($this->getArrayCopy(), $preserveKeys)
        );
    }

    /**
     * Searches this {@see Map} for a given value and returns the first
     * corresponding key if successful.
     *
     * Searches for needle in this {@see Map}.
     *
     * @param  TValue  $needle
     *   The searched value.
     *
     *   > **Note**:
     *   >
     *   > If **needle** is a string, the comparison is done in a case-sensitive
     *   > manner.
     *
     * @param  bool  $strict
     *   If **strict** is set to `true` then the {@see ArrayMap::search()} function
     *   will search for identical elements in this {@see Map}. This means it
     *   will also perform a
     *   {@link https://php.net/types strict type comparison} of the **needle**
     *   in this {@see Map} and objects must be the same instance.
     *
     * @return TKey|false
     *   Returns the key for **needle** if it is found in this {@see Map},
     *   `false` otherwise.
     *
     *   If **needle** is found in this {@see Map} more than once, the first
     *   matching key is returned. To return the keys for all matching values,
     *   use {@see ArrayMap::keys()} with the optional **filterValue** parameter
     *   instead.
     *
     *   > **Warning**
     *   > This function may return Boolean `false`, but may also return a
     *   > non-Boolean value which evaluates to `false`. Please read the section
     *   > on {@link https://php.net/boolean Booleans} for more information.
     *   > Use {@link https://php.net/operators.comparison the === operator}
     *   > for testing the return value of this function.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public function search(
        mixed $needle,
        bool $strict = false
    ): int|string|false {
        return array_search($needle, $this->getArrayCopy(), $strict);
    }

    /**
     * Shift an element off the beginning of array.
     *
     * {@see ArrayMap::shift()} shifts the first value of this {@see Map} off and
     * returns it, shortening this {@see Map} by one element and moving
     * everything down. All numerical keys will be modified to start counting
     * from zero while literal keys won't be affected.
     *
     * > Note: This function will {@see ArrayMap::reset() reset} the pointer of
     * > this {@see Map} after use.
     *
     * @return mixed
     *   Returns the shifted value, or `null` if this {@see Map} is empty.
     */
    public function shift(): mixed
    {
        $array = $this->getArrayCopy();
        $result = array_shift($array);
        $this->exchangeArray($array);

        return $result;
    }

    /**
     * Extract a slice of the array.
     *
     * {@see ArrayMap::slice()} returns the sequence of elements from this {@see Map}
     * as specified by the **offset** and **length** parameters.
     *
     * @param  int  $offset
     *   If **offset** is non-negative, the sequence will start at that offset
     *   in this {@see Map}.
     *
     *   If **offset** is negative, the sequence will start that far from the
     *   end of this {@see Map}.
     *
     *   > Note:
     *   >
     *   > The **offset** parameter denotes the position in this {@see Map},
     *   > not the key.
     *
     * @param  int|null  $length
     *   If **length** is given and is positive, then the sequence will have
     *   up to that many elements in it.
     *
     *   If this {@see Map} is shorter than the **length**, then only the
     *   available Map elements will be present.
     *
     *   If **length** is given and is negative then the sequence will stop
     *   that many elements from the end of this {@see Map}.
     *
     *   If it is omitted, then the sequence will have everything from
     *   **offset** up until the end of this {@see Map}.
     *
     * @param  bool  $preserveKeys
     *   > Note:
     *   >
     *   > {@see ArrayMap::slice()} will reorder and reset the integer {@see Map}
     *   > indices by default. This behaviour can be changed by setting
     *   > **preserveKeys** to true. String keys are always preserved
     *   > regardless of this parameter
     *
     * @return static<TKey, TValue>
     *   Returns the slice. If the offset is larger than the size of this
     *   {@see Map}, an empty {@see Map}} is returned.
     */
    public function slice(
        int $offset,
        ?int $length = null,
        bool $preserveKeys = false,
    ): static {
        return $this->withArray(
            array_slice($this->getArrayCopy(), $offset, $length, $preserveKeys)
        );
    }

    /**
     * Remove a portion of this {@see Map} and replace it with something else.
     *
     * Removes the elements designated by offset and length from this
     * {@see Map}, and replaces them with the elements of **replacement**, if
     * supplied.
     *
     * > **Note**:
     * >
     * > Numerical keys are not preserved.
     *
     * > **Note**: If **replacement** is not an iterable, it will be typecast
     * > to one. This may result in unexpected behavior when using an object
     * > or `null` **replacement**.
     *
     * @param  int  $offset
     *   If **offset** is positive then the start of the removed portion is
     *   at that offset from the beginning of this {@see Map}
     *
     *   If **offset** is negative then the start of the removed portion is
     *   at that offset from the end of {@this Map}.
     *
     * @param  int|null  $length
     *   If **length** is omitted, removes everything from **offset** to the
     *   end of this {@see Map}.
     *
     *   If **length** is specified and is positive, then that many elements
     *   will be removed.
     *
     *   If **length** is specified and is negative, then the end of the removed
     *   portion will be that many elements from the end of this {@see Map}.
     *
     *   If **length** is specified and is zero, no elements will be removed.
     *
     *   > **Tip**
     *   > To remove everything from **offset** to the end of this {@see Map}
     *   > when **replacement** is also specified, use `count($input)` for
     *   > length.
     *
     * @param  mixed  $replacement
     *   If **replacement** is specified, then the removed elements are replaced
     *   with elements from this iterable.
     *
     *   If **offset** and **length** are such that nothing is removed, then
     *   the elements from **replacement** are inserted in the place specified
     *   by the **offset**.
     *
     *   > **Note**:
     *   >
     *   > Keys in **replacement** are not preserved.
     *
     *   If **replacement** is just one element it is not necessary to put
     *   `array()` or square brackets around it, unless the element is an
     *   array itself, an object or `null`.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} consisting of the extracted elements.
     */
    public function splice(
        int $offset,
        ?int $length = null,
        mixed $replacement = [],
    ): static {
        $array = $this->getArrayCopy();

        if ($replacement instanceof ArrayObject) {
            $result = $this->withArray(array_splice(
                $array,
                $offset,
                $length,
                $replacement->getArrayCopy(),
            ));
        } elseif ($replacement instanceof Traversable) {
            $result = $this->withArray(array_splice(
                $array,
                $offset,
                $length,
                iterator_to_array($replacement),
            ));
        } else {
            $result = $this->withArray(
                array_splice($array, $offset, $length, $replacement),
            );
        }

        $this->exchangeArray($array);

        return $result;
    }

    /**
     * Calculate the sum of values in this Map.
     *
     * {@see ArrayMap::sum()} returns the sum of values in this {@see Map}.
     *
     * @return int|float
     *   Returns the sum of values as an integer or float; `0` if this
     *   {@see Map} is empty.
     */
    public function sum(): int|float
    {
        return array_sum($this->getArrayCopy());
    }

    /**
     * Computes the difference of this Map to iterables by using a callback
     * function for data comparison.
     *
     * Computes the difference of this {@see Map} to **iterables** by using
     * a callback function for data comparison. This is unlike
     * {@see ArrayMap::diff()} which uses an internal function for comparing the
     * data.
     *
     * @template V
     *
     * @phpstan-type value_compare_func
     *
     * @param  callable(TValue|V $a, TValue|V $b): int  $valueCompareFunc
     *   The comparison function must return an integer less than, equal to,
     *   or greater than zero if the first argument is considered to be
     *   respectively less than, equal to, or greater than the second.
     *
     *   > **Caution**
     *   > Returning non-integer values from the comparison function, such as
     *   > `float`, will result in an internal cast to `int` of the callback's
     *   > return value. So values such as `0.99` and `0.1` will both be cast
     *   > to an integer value of 0, which will compare such values as equal.
     *
     *   > **Caution**
     *   > The sorting callback must handle any value from either this
     *   > {@see Map} or any iterable in any order, regardless of the order
     *   > they were originally provided. This is because each individual array
     *   > is first sorted before being compared against other arrays.
     *
     * @param  iterable<array-key, V>  ...$iterables
     *   Iterables to compare against.
     *
     * @return static
     *   Returns a new {@see Map} containing all the values of this {@see Map}
     *   that are not present in any of the other arguments.
     *
     * @noinspection PhpIllegalArrayKeyTypeInspection
     */
    public function udiff(callable $valueCompareFunc, iterable ...$iterables): static
    {
        foreach ($iterables as $key => $iterable) {
            if ($iterable instanceof ArrayObject) {
                $iterables[$key] = $iterable->getArrayCopy();
            } elseif ($iterable instanceof Traversable) {
                $iterables[$key] = iterator_to_array($iterable);
            }
        }

        $iterables[] = $valueCompareFunc;

        return $this->withArray(
            array_udiff($this->getArrayCopy(), ...$iterables),
        );
    }

    /**
     * Return the current element in this Map.
     *
     * Every {@see Map} has an internal pointer to its "current" element,
     * which is initialized to the first element inserted into the {@see Map}.
     *
     * @return TValue|false
     *   The {@see ArrayMap::current()} function simply returns the value of the
     *   {@see Map} element that's currently being pointed to by the internal
     *   pointer. It does not move the pointer in any way. If the internal
     *   pointer points beyond the end of the elements list or this {@see Map}
     *   is empty, {@see ArrayMap::current()} returns `false`.
     *
     *   > **Warning**
     *   > This function may return Boolean `false`, but may also return a
     *   > non-Boolean value which evaluates to `false`. Please read the section
     *   > on {@link https://php.net/boolean Booleans} for more information.
     *   > Use {@link https://php.net/operators.comparison the === operator}
     *   > for testing the return value of this function.
     */
    public function current(): mixed
    {
        return $this->getIterator()->current();
    }

    /**
     * Set the internal pointer of this Map to its last element.
     *
     * {@see ArrayMap::end()} advances this {@see Map}'s internal pointer to the
     * last element, and returns its value.
     *
     * @return TValue|false
     *   Returns the value of the last element or false for empty {@see Map}.
     */
    public function end(): mixed
    {
        $count = $this->count();
        if ($count < 0) {
            return false;
        }

        $this->getIterator()->seek($count - 1);

        return $this->getIterator()->current();
    }

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
    public function contains(mixed $needle, bool $strict = false): bool
    {
        return \in_array($needle, $this->getArrayCopy(), $strict);
    }

    /**
     * Fetch a key from this {@see Map}.
     *
     * {@see ArrayMap::key()} returns the index element of the current {@see Map}
     * position.
     *
     * @return TKey|null
     *   The {@see ArrayMap::key()} method simply returns the key of this
     *   {@see Map}'s element that's currently being pointed to by the internal
     *   pointer. It does not move the pointer in any way. If the internal
     *   pointer points beyond the end of the elements list or this Map is
     *   empty, {@see ArrayMap::key()} returns `null`.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public function key(): int|string|null
    {
        return $this->getIterator()->key();
    }

    public function list(&...$vars): void
    {
        foreach ($vars as $name => &$var) {
            if (! $this->offsetExists($name)) {
                trigger_error("Undefined Map key {$name}", E_USER_WARNING);
            }

            $var = $this->offsetGet($name);
        }
    }

    /**
     * Construct a new Map from an array.
     *
     * This method is primarily provided so classes extending {@see Map} have
     * a way to work with their own constructor.
     *
     * @template K of array-key
     * @template V
     *
     * @param  iterable<K, V>  $array
     *   The **array** parameter accepts any
     *   {@link https://php.net/iterable iterable}.
     *
     * @param  int-mask-of<self::FLAG_*>  $flags
     *   Flags to control the behaviour of the {@see Map}.
     *
     * @param  class-string<ArrayIterator>  $iteratorClass
     *   Specify the class that will be used for iteration of the {@see Map}
     *   object.
     *
     * @return static<K, V>
     */
    protected static function fromArray(
        iterable  $array = [],
        int       $flags = 0,
        string    $iteratorClass = ArrayIterator::class
    ): static {
        return new static($array, $flags, $iteratorClass);
    }

    /**
     * Returns a new Map with the provided elements.
     *
     * The new Map will have the same flags and Iterator Class as this one.
     *
     * @template K of array-key
     * @template V
     *
     * @param  iterable<K, V>  $array  The Map elements.
     * @return static<K, V> The new Map.
     */
    final protected function withArray(iterable $array): static
    {
        return static::fromArray(
            $array,
            $this->getFlags(),
            $this->getIteratorClass()
        );
    }

    public function unshift(): mixed
    {
        // TODO: Implement unshift() method.
    }

    public function __serialize(): array
    {
        // TODO: Implement __serialize() method.
    }

    public function __unserialize(array $data): void
    {
        // TODO: Implement __unserialize() method.
    }
}
