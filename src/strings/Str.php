<?php
declare(strict_types=1);

namespace empaphy\usephul\strings;

use ArrayAccess;
use Deprecated;
use Error;
use JetBrains\PhpStorm\NoReturn;
use ValueError;
use function str_contains;
use function str_decrement;
use function str_ends_with;
use function str_increment;
use function str_starts_with;

/**
 * @implements ArrayAccess<int,string>
 *
 * @readonly
 */
class Str implements \Stringable, \ArrayAccess
{
    public function __construct(protected string $string) {}

    public function __toString(): string
    {
        return $this->string;
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    /**
     * Determine if this string contains a given substring.
     *
     * Performs a case-sensitive check indicating if **needle** is contained
     * in this {@see Str}ing.
     *
     * @param  string  $needle
     *   The substring to search for.
     *
     * @return bool
     *   Returns {@see true} if **needle** is in this {@see Str}ing,
     *   {@see false} otherwise.
     */
    public function contains(string $needle): bool
    {
        return str_contains($this->string, $needle);
    }

    /**
     * Decrement an alphanumeric string.
     *
     * @return static
     *   Returns the decremented alphanumeric ASCII string.
     *
     * @throws ValueError
     *   If this {@see Str}ing is empty, not an alphanumeric ASCII string, or
     *   cannot be decremented (for example, "A" or "0").
     */
    public function decrement(): static
    {
        return static::fromString(str_decrement($this->string));
    }

    /**
     * Checks if this String ends with a given substring.
     *
     * Performs a case-sensitive check indicating if this {@see Str}ing ends
     * with **needle**.
     *
     * @param  string  $needle
     *   The substring to search for.
     *
     * @return bool
     *   Returns {@see true} if this {@see Str}ing ends with **needle**,
     *   {@see false} otherwise.
     */
    public function endsWith(string $needle): bool
    {
        return str_ends_with($this->string, $needle);
    }

    /**
     * Increment an alphanumeric String.
     *
     * @return static
     *   Returns a new incremented alphanumeric ASCII {@see Str}ing.
     *
     * @throws ValueError
     *   If this {@see Str}ing is empty, or not an alphanumeric ASCII string.
     */
    public function increment(): static
    {
        return static::fromString(str_increment($this->string));
    }

    /**
     * Checks if a String starts with a given substring.
     *
     * Performs a case-sensitive check indicating if this {@see Str}ing begins
     * with **needle**.
     *
     * @param  string  $needle
     *   The substring to search for in the haystack.
     *
     * @return bool
     *   Returns {@see true} if this {@see Str}ing begins with **needle**,
     *   {@see false} otherwise.
     */
    public function startsWith(string $needle): bool
    {
        return str_starts_with($this->string, $needle);
    }

    /**
     * @param  int  $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->string[$offset]);
    }

    /**
     * @param  int  $offset
     * @return static
     */
    public function offsetGet(mixed $offset): static
    {
        return static::fromString($this->string[$offset]);
    }

    /**
     * @param  int  $offset
     * @param  string  $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->string[$offset] = $value;
    }

    /**
     * @param  int  $offset
     * @return never
     *
     * @throws Error
     *   Cannot unset string offsets.
     *
     * @noinspection PhpDocSignatureInspection
     */
    #[Deprecated]
    public function offsetUnset(mixed $offset): void
    {
        throw new Error('Cannot unset string offsets');
    }
}
