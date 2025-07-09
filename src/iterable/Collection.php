<?php

declare(strict_types=1);

namespace empaphy\usephul\iterable;

/**
 * A Collection represents a group of objects, known as its elements.
 *
 *   - An ordered Collection is a {@see Sequence}.
 *       - A Sequence with index access is a {@see Listable}.
 *   - A Collection without duplicates is a {@see Set}
 *
 * @template TElement
 *
 * @extends \IteratorAggregate<int, TElement>
 */
interface Collection extends \Countable, \IteratorAggregate
{
    public function isEmpty(): bool;

    /**
     * Checks if a value exists.
     *
     * Searches for __needle__ using loose comparison unless __strict__ is set.
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
     * Creates a copy of the Colletion as an array.
     *
     * Exports the {@see Collection} to an {@see array}.
     *
     * @return array
     *   Returns a copy of this {@see Collection} as an {@see array}.
     */
    public function getArrayCopy(): array;
}
