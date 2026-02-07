<?php

declare(strict_types=1);

namespace Tests\Unit\pcre;

use Generator;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\TestCase;
use ValueError;

use function assert;
use function chr;
use function empaphy\usephul\generators\seq;
use function empaphy\usephul\preg_escape;
use function empaphy\usephul\Var\is_non_empty_string;
use function preg_match;

#[CoversFunction('empaphy\usephul\preg_escape')]
#[UsesFunction('empaphy\usephul\Var\is_non_empty_string')]
class PregEscapeTest extends TestCase
{
    public static function alphanumericCharacters(): Generator
    {
        for ($i = 0x30; $i < 0x3a; $i++) {
            yield [chr($i)];
        }

        for ($i = 0x41; $i < 0x5b; $i++) {
            yield [chr($i)];
        }

        for ($i = 0x61; $i < 0x7b; $i++) {
            yield [chr($i)];
        }
    }

    /**
     * Returns all whitespace characters.
     *
     * > The space characters are HT (9), LF (10), VT (11), FF (12),
     * > CR (13), and space (32). Notice that this list includes the VT
     * > character (code 11).
     * See: https://www.php.net/regexp.reference.character-classes
     */
    public static function whitespaceCharacters(): Generator
    {
        for ($i = 9; $i < 14; $i++) {
            yield [chr($i)];
        }

        yield [chr(32)];
    }

    private static function delimiters(): Generator
    {
        $delimiters = '!"#$%&\'*+,-./:;=?@^_`|~';

        yield from seq($delimiters);
    }

    #[TestWith(['pattern' => 'foo/bar', 'delimiter' => '/', 'expected' => 'foo\\/bar'])]
    #[TestWith(['pattern' => 'foo\\/bar', 'delimiter' => '/', 'expected' => 'foo\\/bar'])]
    #[TestWith(['pattern' => '', 'delimiter' => '/', 'expected' => ''])]
    public function testEscapesDelimitersWhenAppropriate(string $pattern, string $delimiter, string $expected): void
    {
        assert(is_non_empty_string($delimiter));
        $value = preg_escape($pattern, $delimiter);
        $this->assertSame($expected, $value);
    }

    #[DataProvider('delimitersProvider')]
    public function testReturnsValidPatternsForAllDelimiters(
        string $expression,
        string $delimiter,
        string $subject,
    ): void {
        assert(is_non_empty_string($delimiter));
        $pattern = $delimiter . preg_escape($expression, $delimiter) . $delimiter;
        $matched = preg_match($pattern, $subject, $matches);
        $this->assertEquals(1, $matched);
        $this->assertSame($expression, $matches[0]);
    }

    public static function delimitersProvider(): Generator
    {
        foreach (self::delimiters() as $delimiter) {
            yield ["foo{$delimiter}bar", $delimiter, "quxfoo{$delimiter}barbaz"];
        }
    }

    public function testThrowsValueErrorWhenDelimiterIsEmpty(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('preg_escape(): Argument #2 ($delimiter) must be a single character');
        preg_escape('foo', ''); // @phpstan-ignore argument.type
    }

    public function testThrowsValueErrorWhenDelimiterIsLongerThanASingleCharacter(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('preg_escape(): Argument #2 ($delimiter) must be a single character');
        preg_escape('foo', '//');
    }

    #[DataProvider('alphanumericCharacters')]
    public function testThrowsValueErrorWhenTheDelimiterIsAlphanumeric(string $delimiter): void
    {
        assert($delimiter !== '');
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage(
            'preg_escape(): Argument #2 ($delimiter) must be a '
            . 'non-alphanumeric, non-backslash, non-whitespace character',
        );
        preg_escape('foo', $delimiter);
    }

    public function testThrowsValueErrorWhenTheDelimiterIsABackslash(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage(
            'preg_escape(): Argument #2 ($delimiter) must be a '
            . 'non-alphanumeric, non-backslash, non-whitespace character',
        );
        preg_escape('foo', '\\');
    }

    #[DataProvider('whitespaceCharacters')]
    public function testThrowsValueErrorWhenTheDelimiterIsWhitespace(string $delimiter): void
    {
        assert(is_non_empty_string($delimiter));
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage(
            'preg_escape(): Argument #2 ($delimiter) must be a '
            . 'non-alphanumeric, non-backslash, non-whitespace character',
        );
        preg_escape('foo', $delimiter);
    }

    #[DataProvider('bracketStyleDelimitersProvider')]
    public function testThrowsValueErrorWhenGivenABracketStyleDelimiter(string $delimiter): void
    {
        assert(is_non_empty_string($delimiter));
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('preg_escape(): Argument #2 ($delimiter) cannot be a bracket style delimiter');
        preg_escape('foo', $delimiter);
    }

    public static function bracketStyleDelimitersProvider(): Generator
    {
        foreach (seq('(){}[]<>') as $delimiter) {
            yield [$delimiter];
        }
    }
}
