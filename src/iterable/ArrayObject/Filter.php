<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable\ArrayObject;

use empaphy\usephul\iterable\FilterMode;
use function array_all;
use function array_any;
use function array_filter;
use function array_find;
use function array_find_key;

/**
 * Contains methods that find values or keys.
 *
 * Common properties of these methods:
 *   - They check if {@see $this} satisfies a **callback** in some way.
 *   - They don't modify {@see $this}.
 *   - They return either {@see bool}, {@see TKey}, {@see TValue} or a subset
 *     of $this.
 *
 * @template TKey of bool
 * @template TValue
 */
trait Filter
{
    /**
     * Filters elements using a callback function.
     *
     * Iterates over each element's value, passing them to the **callback**
     * function. If the **callback** function returns {@see true}, the value
     * is returned into the result.
     *
     * Keys are preserved.
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
     *   If no callback is supplied, all elements with
     *   {@link https://php.net/empty empty} values will be removed.
     *
     * @param  FilterMode  $mode
     *   Flag determining what arguments are sent to **callback**:
     *
     * @return static<TKey, TValue>
     *   Returns the filtered elements.
     */
    public function filter(
        ?callable $callback = null,
        FilterMode $mode = FilterMode::UseValue
    ): static {
        return $this->withArray(
            array_filter($this->getArrayCopy(), $callback, $mode->value)
        );
    }

    /**
     * Checks if all elements satisfy a callback function.
     *
     * This method returns {@see true} if the given **callback** returns
     * {@see true} for all elements. Otherwise, the method returns {@see false}.
     *
     * @param  callable(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element. If **callback**
     *   returns {@see false}, {@see false} is returned from
     *   {@see Filter::all() all()} and **callback** will not be
     *   called for further elements.
     *
     * @return bool
     *   Returns {@see true} if **callback** returns {@see true} for all
     *   elements. Otherwise, returns {@see false}.
     */
    public function all(callable $callback): bool
    {
        return array_all($this->getArrayCopy(), $callback);
    }

    /**
     * Checks if at least one element satisfies a callback function.
     *
     * This method returns {@see true} if the given **callback** returns
     * {@see true} for any element. Otherwise, the method returns {@see false}.
     *
     * @param  callback(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element. If this function
     *   returns {@see true}, {@see true} is returned from
     *   {@see Filter::any() any()} and the callback will not be
     *   called for further elements.
     *
     * @return bool
     *   Returns {@see true} if there is at least one element for which
     *   **callback** returns {@see true}. Otherwise, the method returns
     *   {@see false}.
     */
    public function any(callable $callback): bool
    {
        return array_any($this->getArrayCopy(), $callback);
    }

    /**
     * Returns the first element satisfying a callback function.
     *
     * This method returns the value of the first element for which the given
     * **callback** returns {@see true}. If no matching element is found the
     * function returns {@see null}.
     *
     * @param  callable(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element.
     *
     *   If this function returns {@see true}, the value is returned from
     *   {@see Filter::find() find()} and the **callback** will
     *   not be called for further elements.
     *
     * @return TValue|null
     *   Returns the value of the first element for which the
     *   **callback** returns {@see true}. If no matching element is found
     *   {@see null} is returned.
     */
    public function find(callable $callback): mixed
    {
        return array_find($this->getArrayCopy(), $callback);
    }

    /**
     * Returns the key of the first element satisfying a callback function.
     *
     * This method returns the key of the first element for which the given
     * **callback** returns {@see true}. If no matching element is found the
     * function returns {@see null}.
     *
     * @param  callable(TValue $value, TKey $key): bool  $callback
     *   The callback function to call to check each element.
     *
     *   If this function returns {@see true}, the key is returned from
     *   {@see Filter::findKey() findKey()} and the callback will
     *   not be called for further elements.
     *
     * @return TKey|null
     *   Returns the key of the first element for which the **callback** returns
     *   {@see true}. If no matching element is found {@see null} is returned.
     */
    public function findKey(callable $callback): mixed
    {
        return array_find_key($this->getArrayCopy(), $callback);
    }
}
