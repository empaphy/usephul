<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable\ArrayObject;

/**
 * Provides functions that are relevant for collections.
 */
trait Collecting
{
    /**
     * Determine whether the Collection is empty.
     *
     * Determine whether the {@see Collection} is considered to be empty. A
     * {@see Collection} is considered empty if it doesn't contain any elements.
     *
     * @return bool
     *   Returns {@see true} if the {@see Collection} is empty. Otherwise,
     *   returns {@see false}.
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
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
}
