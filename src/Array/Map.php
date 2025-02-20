<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul\Array;

use ArrayIterator;
use iterable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \ArrayObject<TKey, TValue>
 */
class Map extends \ArrayObject
{
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
        parent::__construct(\iterator_to_array($array), $flags, $iteratorClass);
    }

    /**
     * Fill a Map with values.
     *
     * Fills a {@see Map} with **count** entries of the value of the **value**
     * parameter, keys starting at the **startIndex** parameter.
     *
     * @template V
     *
     * @param  int  $startIndex
     *   The first index of the returned {@see Map}.
     *
     * @param  non-negative-int  $count
     *   Number of elements to insert. Must be greater than or equal to zero,
     *   and less than or equal to `2147483647`.
     *
     * @param  V  $value
     *   Value to use for filling.
     *
     * @return static<int, V>
     *   Returns the filled {@see Map}.
     */
    public static function fill(
        int $startIndex,
        int $count,
        mixed $value
    ): static {
        return static::fromArray(\array_fill($startIndex, $count, $value));
    }

    /**
     * Fill a Map with values, specifying keys.
     *
     * Fills a {@see Map} with the value of the **value** parameter, using the
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
     *   Returns the filled {@see Map}.
     */
    public static function fillKeys(iterable $keys, mixed $value): static
    {
        return static::fromArray(
            \array_fill_keys(\iterator_to_array($keys), $value)
        );
    }

    /**
     * Checks if all Map elements satisfy a callback function.
     *
     * {@see Map::all()} returns `true`, if the given **callback** returns
     * `true` for all elements. Otherwise, the method returns `false`.
     *
     * @param  callable(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element. If this function
     *   returns `false`, `false` is returned from {@see Map::all()} and the
     *   callback will not be called for further elements.
     *
     * @return bool
     *   The method returns `true` if **callback** returns `true` for all
     *   elements. Otherwise, the method returns `false`.
     */
    public function all(callable $callback): bool
    {
        return \array_all($this->getArrayCopy(), $callback);
    }

    /**
     * Checks if at least one Map element satisfies a callback function.
     *
     * {@see Map::any()} returns `true` if the given **callback** returns
     * `true` for any element. Otherwise, the method returns `false`.
     *
     * @param  callback(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element. If this function
     *   returns `true`, `true` is returned from {@see Map::any()} and the
     *   callback will not be called for further elements.
     *
     * @return bool
     *   The method returns `true` if there is at least one element for which
     *   callback returns `true`. Otherwise, the method returns `false`.
     */
    public function any(callable $callback): bool
    {
        return \array_any($this->getArrayCopy(), $callback);
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
            \array_change_key_case($this->getArrayCopy(), $case->value)
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
            \array_chunk($this->getArrayCopy(), $length, $preserveKeys)
            as $key => $chunk
        ) {
            $chunks[$key] = $this->withArray($chunk);
        }

        return $chunks;
    }

    /**
     * Return the values from a single column.
     *
     * {@see Map::column()} returns the values from a single column of this
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
            \array_column($this->getArrayCopy(), $columnKey, $indexKey)
        );
    }

    /**
     * Counts the occurences of each distinct value.
     *
     * {@see Map::countValues()} returns a new {@see Map} using the values of
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
            \array_count_values($this->getArrayCopy())
        );
    }

    /**
     * Computes the difference of this Map to given arrays.
     *
     * Compares this {@see Map} against one or more **arrays** and returns the
     * values in this {@see Map} that are not present in any of the **arrays**.
     *
     * @param  iterable  ...$arrays
     *   Arrays to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the entries from this
     *   {@see Map} that are not present in any of the **arrays**. Keys in
     *   the {@see Map} are preserved.
     */
    public function diff(iterable ...$arrays): static
    {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(\array_diff($this->getArrayCopy(), ...$arrays));
    }

    /**
     * Computes the difference of arrays with additional index check.
     *
     * Compares this {@see Map} against **arrays** and returns the difference.
     * Unlike {@see Map::diff()} the array keys are also used in the comparison.
     *
     * @param  iterable  ...$arrays
     *   Arrays to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the values from this {@see Map}
     *   that are not present in any of the **arrays**.
     */
    public function diffAssoc(iterable ...$arrays): static
    {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(
            \array_diff_assoc($this->getArrayCopy(), ...$arrays)
        );
    }

    /**
     * Computes the difference of this Map to arrays using keys for comparison.
     *
     * Compares the keys from this {@see Map} against the keys from **arrays**
     * and returns the difference. This method is like {@see Map::diff()}
     * except the comparison is done on the keys instead of the values.
     *
     * @param  iterable  ...$arrays
     *   Arrays to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a {@see Map} containing all the entries from array whose keys
     *   are absent from all the other arrays.
     */
    public function diffKey(iterable ...$arrays): static
    {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(
            \array_diff_key($this->getArrayCopy(), ...$arrays)
        );
    }

    /**
     * Computes the difference of this Map to given arrays with additional
     * index check which is performed by a user supplied callback function.
     *
     * Compares this {@see Map} against **arrays** and returns the difference.
     * Unlike {@see Map::diff()} the array keys are used in the comparison.
     *
     * Unlike {@see Map::diffAssoc()} a user supplied callback function is
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
     * @param  iterable<K, V>  ...$arrays
     *   Arrays to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns an array containing all the entries from array that are not
     *   present in any of the other arrays.
     */
    public function diffUAssoc(
        callable $keyCompareFunc,
        iterable ...$arrays
    ): static {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(
            \array_diff_uassoc(
                $this->getArrayCopy(),
                ...[...$arrays, $keyCompareFunc]
            )
        );
    }

    /**
     * Computes the difference of this Map to given arrays using a callback
     * function on the keys for comparison.
     *
     * Compares the keys from this {@see Map} against the keys from **arrays**
     * and returns the difference. This method is like {@see Map::diff()}
     * except the comparison is done on the keys instead of the values.
     *
     * Unlike {@see Map::diffKey()} a user supplied callback function is used
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
     * @param  iterable<K, V>  ...$arrays
     *   Arrays to compare against.
     *
     * @return static<TKey, TValue>
     *   Returns a {@see Map} containing all the entries from this {@see Map}
     *   that are not present in any of the **arrays**.
     */
    public function diffUKey(callable $keyCompareFunc, iterable ...$arrays): static
    {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(
            \array_diff_ukey(
                $this->getArrayCopy(),
                ...[...$arrays, $keyCompareFunc]
            )
        );
    }

    /**
     * Filters elements of this Map using a callback function.
     *
     * Iterates over each value in this {@see Map}, passing them to the
     * **callback** function. If the **callback** function returns `true`,
     * the value is returned into the result {@see Map}.
     *
     * Keys are preserved, and may result in gaps if the {@see Map} was
     * indexed. The result {@see Map} can be reindexed using the
     * {@see Map::values()} method.
     *
     * @param  null|(
     *   $mode is FilterMode::UseBoth ?
     *       callable(TValue $value, TKey $key): bool : (
     *   $mode is FilterMode::UseKey ?
     *       callable(TKey $key): bool :
     *       callable(TValue $value): bool )
     *   )  $callback
     *   The callback function to use.
     *
     *   If no callback is supplied, all empty entries of this {@see Map}
     *   will be removed. See {@link https://php.net/empty empty()} for how
     *   PHP defines empty in this case.
     *
     * @param  FilterMode  $mode
     *   Flag determining what arguments are sent to **callback**:
     *
     * @return static<TKey, TValue>
     *   Returns a new, filtered {@see Map}.
     */
    public function filter(
        ?callable $callback = null,
        FilterMode $mode = FilterMode::UseValue
    ): static {
        return $this->withArray(
            \array_filter($this->getArrayCopy(), $callback, $mode->value)
        );
    }

    /**
     * Returns the first element satisfying a callback function.
     *
     * {@see Map::find()} returns the value of the first element of this
     * {@see Map} for which the given **callback** returns `true`. If no
     * matching element is found the function returns `null`.
     *
     * @param  callable(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element.
     *
     *   If this function returns `true`, the value is returned from
     *   {@see Map::find()} and the **callback** will not be called for
     *   further elements.
     *
     * @return TValue|null
     *   The method returns the value of the first element for which the
     *   **callback** returns `true`. If no matching element is found the
     *   function returns `null`.
     */
    public function find(callable $callback): mixed
    {
        return \array_find($this->getArrayCopy(), $callback);
    }

    /**
     * Returns the key of the first element satisfying a callback function.
     *
     * {@see Map::findKey()} returns the key of the first element of this
     * {@see Map} for which the given **callback** returns `true`. If no
     * matching element is found the function returns `null`.
     *
     * @param  callable(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element.
     *
     *   If this function returns `true`, the key is returned from
     *   {@see Map::findKey()} and the callback will not be called for further
     *   elements.
     *
     * @return TKey|null
     *   The method returns the key of the first element for which the
     *   **callback** returns `true`. If no matching element is found the
     *   method returns `null`.
     */
    public function findKey(callable $callback): mixed
    {
        return \array_find_key($this->getArrayCopy(), $callback);
    }

    /**
     * Exchanges all keys with their associated values.
     *
     * {@see Map::flip()} returns a new {@see Map} in flip order, i.e. keys
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
        return $this->withArray(\array_flip($this->getArrayCopy()));
    }

    /**
     * Computes the intersection of this Map with given arrays.
     *
     * {@see Map::intersect()} returns a new {@see Map} containing all the
     * values of this {@see Map} that are present in all the arguments. Note
     * that keys are preserved.
     *
     * @param  iterable  ...$arrays
     *   Arrays to compare values against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the values in this {@see Map}
     *   whose values exist in all the parameters.
     */
    public function intersect(iterable ...$arrays): static
    {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(
            \array_intersect($this->getArrayCopy(), ...$arrays)
        );
    }

    /**
     * Computes the intersection of this Map with given arrays with additional
     * index check.
     *
     * {@see Map::intersectAssoc()} returns a new {@see Map} containing all
     * the values of this {@see Map} that are present in all the arguments.
     * Note that the keys are also used in the comparison unlike in
     * {@see Map::intersect()}.
     *
     * @param  iterable  ...$arrays
     *   Arrays to compare values against.
     *
     * @return static<TKey, TValue>
     *   Returns a new {@see Map} containing all the values in this {@see Map}
     *   that are present in all the arguments.
     */
    public function intersectAssoc(iterable ...$arrays): static
    {
        foreach ($arrays as $key => $array) {
            $arrays[$key] = \iterator_to_array($array);
        }

        return $this->withArray(
            \array_intersect_assoc($this->getArrayCopy(), ...$arrays)
        );
    }

    /**
     * Checks whether a given array is a list.
     *
     * Determines if this {@see Map} is a list. It is considered a list if
     * its keys consist of consecutive numbers from `0` to `count($array)-1`.
     *
     * @return bool
     *   Returns `true` if this {@see Map} is a list, `false` otherwise.
     */
    public function isList(): bool
    {
        return \array_is_list($this->getArrayCopy());
    }

    /**
     * Checks if the given key or index exists in this Map.
     *
     * {@see Map::keyExists()} returns `true` if the given **key** is set in
     * this {@see Map}. **key** can be any value possible for an array index.
     *
     * > **Note**:
     * >
     * > {@see Map::keyExists()} will search for the keys in the first dimension
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
     * Set the internal pointer of this Map to its first element.
     *
     * {@see Map::reset()} rewinds this {@see Map}'s internal pointer to the
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
}
