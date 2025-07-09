<?php
declare(strict_types=1);

namespace empaphy\usephul\iterable;

/**
 * A Map that has a well-defined encounter order, that supports operations at
 * both ends, and that is reversible.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends Map<TKey, TValue>
 */
interface OrderedMap extends Map
{

}
