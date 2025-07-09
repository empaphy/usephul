<?php
declare(strict_types=1);

namespace empaphy\usephul\iterable\ArrayObject;

use function array_key_last;
use function array_shift;

/**
 * @template TValue
 */
trait Stacking
{
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
     * @return TValue|null
     *   Returns the shifted value, or `null` if this {@see Map} is empty.
     */
    public function shift(): mixed
    {
        $array = $this->getArrayCopy();
        $result = array_shift($array);
        $this->exchangeArray($array);

        return $result;
    }

    public function unshift(): mixed
    {
        // TODO: Implement unshift() method.
    }
}
