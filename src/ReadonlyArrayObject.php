<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * @see \ArrayObject
 *
 * @template TKey of array-key
 * @template TValue
 * @template TIterator of \ArrayIterator
 *
 * @implements \IteratorAggregate<TKey, TValue>
 * @implements \ArrayAccess<TKey, TValue>
 */
readonly class ReadonlyArrayObject implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @var \ArrayObject<TKey, TValue>
     */
    private \ArrayObject $arrayObject;

    /**
     * Construct a new readonly array object.
     *
     * This constructs a new readonly array object.
     *
     * @param array<TKey, TValue>|object $array Accepts an {@see array} or an {@see object}.
     * @param int-mask-of<\ArrayObject::*> $flags Flags to control the behaviour.
     * @param class-string<TIterator> $iteratorClass Specify the class that will be used for iteration.
     */
    public function __construct(
        array|object $array = [],
        int          $flags = 0,
        string       $iteratorClass = \ArrayIterator::class
    )
    {
        $this->arrayObject = new \ArrayObject($array, $flags, $iteratorClass);
    }

    /**
     * Creates a copy of the {@see ReadonlyArrayObject}.
     *
     * Exports the {@see ReadonlyArrayObject} to an array.
     *
     * @return array<TValue> Returns a copy of the array. When the {@see ReadonlyArrayObject} refers to an object an
     *                       array of the properties of that object will be returned.
     */
    public function getArrayCopy(): array
    {
        return $this->arrayObject->getArrayCopy();
    }

    /**
     * Gets the behavior flags.
     *
     * Gets the behavior flags of the {@see ReadonlyArrayObject}.
     *
     * @return int-mask-of<\ArrayObject::*> Returns the behavior flags of the {@see ReadonlyArrayObject}.
     */
    public function getFlags(): int
    {
        return $this->arrayObject->getFlags(); // @phpstan-ignore return.type
    }

    /**
     * Create a new iterator from a {@see \ReadonlyArrayObject} instance.
     *
     * Create a new {@see \Iterator} (default is {@see \ArrayIterator}) from a {@see \ReadonlyArrayObject} instance.
     *
     * @return \Iterator An iterator from an {@see \ReadonlyArrayObject}.
     */
    public function getIterator(): \Iterator
    {
        return $this->arrayObject->getIterator();
    }

    /**
     * Gets the iterator classname for the {@see \ReadonlyArrayObject}.
     *
     * Gets the class name of the array iterator that is used by {@see ReadonlyArrayObject::getIterator()}.
     *
     * @return class-string<TIterator> Returns the iterator class name that is used to iterate over this object.
     */
    public function getIteratorClass(): string
    {
        return $this->arrayObject->getIteratorClass(); // @phpstan-ignore return.type
    }

    /**
     * Returns whether the requested index exists.
     *
     * @param TKey $offset The index being checked.
     * @return bool `true` if the requested index exists, otherwise `false`
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->arrayObject->offsetExists($offset);
    }

    /**
     * Returns the value at the specified index.
     *
     * @param TKey $offset The index with the value.
     * @return TValue|null The value at the specified index or {@see null}.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->arrayObject->offsetGet($offset);
    }

    /**
     * @param TKey $offset The index not being set.
     * @param never $value No new value for the key.
     * @return void No value is returned.
     *
     * @private
     * @deprecated This is a **readonly** array object so setting offsets is not allowed.
     *
     * @internal
     */
    final public function offsetSet(mixed $offset, mixed $value): void // @phpstan-ignore method.childParameterType
    {
        trigger_error("Cannot modify array element '{$offset}' on " . __CLASS__, E_USER_WARNING);
    }

    /**
     * @param TKey $offset The index not being set.
     * @return void No value is returned.
     *
     * @private
     * @deprecated This is a **readonly** array object so unsetting offsets is not allowed.
     *
     * @internal
     */
    final public function offsetUnset(mixed $offset): void
    {
        trigger_error("Cannot unset readonly array element '{$offset}' on " . __CLASS__, E_USER_WARNING);
    }

    /**
     * Get the number of public properties in the {@see ReadonlyArrayObject}.
     *
     * > **Note**:
     * > When the {@see ReadonlyArrayObject} is constructed from an array all properties are public.
     *
     * @return int The number of public properties in the {@see ReadonlyArrayObject}.
     */
    public function count(): int
    {
        return $this->arrayObject->count();
    }
}
