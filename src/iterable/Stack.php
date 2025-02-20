<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable;

/**
 * @template TValue
 */
interface Stack
{
    /**
     * Push one or more elements onto the end of this Map.
     *
     * {@see Stack::push() push()} works as a stack, and Pushes the passed
     * variables onto the end of it. The length is increases by the number of
     * variables pushed.
     *
     * @param  mixed  ...$values
     *   The values to push onto the end of the Stack.
     *
     * @return int
     *   Returns the new number of elements.
     */
    public function push(mixed ...$values): int;

    /**
     * Pop the element off the end of this {@see ArrayMap}.
     *
     * Pops and returns the value of the last element of
     * this {@see ArrayMap}, shortening the {@see ArrayMap} by one element.
     *
     * > **Note**:
     * >
     * > This function will {@see ArrayMap::reset()} the pointer of this {@see ArrayMap}
     * > after use.
     *
     * @return TValue|null
     *   Returns the value of the last element of this {@see ArrayMap}. If this
     *   {@see ArrayMap} is empty, `null` will be returned.
     */
    public function pop(): mixed;

    /**
     * Shift an element off the beginning.
     *
     * Shifts the first value of this {@see ArrayMap} off and returns it, shortening
     * this {@see ArrayMap} by one element and moving
     * everything down. All numerical keys will be modified to start counting
     * from zero while literal keys won't be affected.
     *
     * > Note: This function will {@see ArrayMap::reset() reset} the pointer of
     * > this {@see ArrayMap} after use.
     *
     * @return mixed
     *   Returns the shifted value, or `null` if this {@see ArrayMap} is empty.
     */
    public function shift(): mixed;

    public function unshift(): mixed;
}
