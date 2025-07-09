<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable;

use ArrayAccess;

/**
 * A Sequence (also know as a List) is a Collection that has a well-defined
 * order.
 *
 * Elements can be added and removed from both ends, and elements can be
 * accessed by their position.
 *
 *   - [x] ordered
 *   - [ ] unique elements
 *   - [x] operations at both ends
 *   - [x] elements accessible by index
 *
 * @template TElement
 *
 * @extends Collection<TElement>
 */
interface Sequence extends Collection, ArrayAccess
{
    /**
     * Add/insert a new value at the specified index.
     *
     * @param  int    $index
     * @param  mixed  $element
     * @return void
     */
    public function add(int $index, mixed $element): void;

    /**
     * Push one or more elements onto the end.
     *
     * {@see Sequence::push() push()} works as a stack, and Pushes the passed
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
     * @return TElement|null
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

    public function sort(): void; // TODO

    public function unshift(): mixed;
}
