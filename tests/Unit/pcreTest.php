<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\pcre;

use Generator;
use ValueError;

use function empaphy\usephul\generators\seq;
use function empaphy\usephul\preg_escape;

function alphanumeric_characters(): Generator
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
function whitespace_characters(): Generator
{
    for ($i = 9; $i < 14; $i++) {
        yield [chr($i)];
    }

    yield [chr(32)];
}

function delimiters(): Generator
{
    $delimiters = '!"#$%&\'*+,-./:;=?@^_`|~';

    yield from seq($delimiters);
}

describe('preg_escape()', function () {
    test('escapes delimiters when appropriate', function ($pattern, $delimiter, $expected) {
        $value = preg_escape($pattern, $delimiter);
        expect($value)->toBe($expected);
    })->with([
        ['pattern' => 'foo/bar',   'delimiter' => '/', 'expected' => 'foo\\/bar'],
        ['pattern' => 'foo\\/bar', 'delimiter' => '/', 'expected' => 'foo\\/bar'],
        ['pattern' => '',          'delimiter' => '/', 'expected' => ''],
    ]);

    test('returns valid patterns for all delimiters', function ($expression, $delimiter, $subject) {
        $pattern = $delimiter . preg_escape($expression, $delimiter) . $delimiter;
        $matched = preg_match($pattern, $subject, $matches);
        expect($matched)->toBe(1)->and($matches[0])->toBe($expression);
    })->with(function () {
        foreach (delimiters() as $delimiter) {
            yield ["foo{$delimiter}bar", $delimiter, "quxfoo{$delimiter}barbaz"];
        }
    });

    test('throws ValueError when $delimiter is empty', function () {
        preg_escape('foo', ''); // @phpstan-ignore argument.type
    })->throws(ValueError::class, 'preg_escape(): Argument #2 ($delimiter) must be a single character');

    test('throws ValueError when $delimiter is longer than a single character', function () {
        preg_escape('foo', '//');
    })->throws(ValueError::class, 'preg_escape(): Argument #2 ($delimiter) must be a single character');

    test('throws `ValueError` when the delimiter is alphanumeric', function ($delimiter) {
        preg_escape('foo', $delimiter);
    })->throws(
        ValueError::class,
        'preg_escape(): Argument #2 ($delimiter) must be a '
        . 'non-alphanumeric, non-backslash, non-whitespace character',
    )->with(alphanumeric_characters(...));

    test('throws `ValueError` when the delimiter is a backslash', function () {
        preg_escape('foo', '\\');
    })->throws(
        ValueError::class,
        'preg_escape(): Argument #2 ($delimiter) must be a '
        . 'non-alphanumeric, non-backslash, non-whitespace character',
    );

    test('throws `ValueError` when the delimiter is whitespace', function ($delimiter) {
        preg_escape('foo', $delimiter);
    })->throws(
        ValueError::class,
        'preg_escape(): Argument #2 ($delimiter) must be a '
        . 'non-alphanumeric, non-backslash, non-whitespace character',
    )->with(whitespace_characters(...));

    test('throws `ValueError` when given a bracket style `$delimiter`', function ($delimiter) {
        preg_escape('foo', $delimiter);
    })->throws(
        ValueError::class,
        'preg_escape(): Argument #2 ($delimiter) cannot be a bracket style delimiter',
    )->with(function () {
        yield from seq('(){}[]<>');
    });
});
