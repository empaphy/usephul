<?php
declare(strict_types=1);

namespace empaphy\usephul\strings;

use ValueError;

use function strlen;

class Char implements Byte
{
    public function __construct(protected string $char)
    {
        if (strlen($char) !== 1) {
            throw new ValueError('Char must be a single character');
        }
    }

    public static function fromString(string $char): static
    {
        if (strlen($char) !== 1) {
            throw new ValueError('Char must be a single character');
        }

        return new Char($char);
    }

    public static function fromByte(int|Byte $codepoint): static
    {
        return static::fromString(chr($codepoint));
    }
}
