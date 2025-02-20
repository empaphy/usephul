<?php

declare(strict_types=1);

namespace empaphy\usephul\iterable;

/**
 * A Collection represents a group of objects, known as its elements.
 *
 * Some collections allow duplicate elements and others do not. Some are
 * ordered, and others are unordered.
 *
 * Collections that have a defined order generally implement {@see Sequence}.
 */
interface Collection extends \Countable, \IteratorAggregate
{
    /**
     * Checks if a value exists.
     *
     * Searches for **needle** using loose comparison unless **strict** is set.
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
}
