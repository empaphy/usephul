<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   PCRE
 */

declare(strict_types=1);

namespace empaphy\usephul;

use ValueError;

use function assert;
use function preg_last_error_msg;
use function preg_match;
use function preg_quote;
use function preg_replace;
use function sprintf;
use function str_contains;
use function strlen;

/**
 * Escapes all instances of the given PCRE delimiter character in a raw regular
 * expression pattern.
 *
 * {@see preg_escape()} takes __pattern__ and puts a backslash in front
 * of every unescaped __delimiter__. This is useful to prepare raw regular
 * expression patterns for use with PHP's PCRE functions.
 *
 * For example:
 *
 *     preg_escape('foo_bar', '_');   // returns `foo\_bar`
 *     preg_escape('foo\\_bar', '_'); // returns `foo\_bar`
 *
 * @param  string  $pattern
 *   The input pattern.
 *
 * @param  non-empty-string  $delimiter
 *   The delimiter to be escaped. Must be a single non-alphanumeric,
 *   non-backslash, non-whitespace character.
 *
 *   This function doesn't support bracket style delimiters (`(`, `)`,
 *   `{`, `}`, `[`, `]`, `<`, and `>`).
 *
 * @return string
 *   The __pattern__ with all instances of __delimiter__ escaped where needed.
 *
 * @throws ValueError
 *   Thrown if __delimiter__ is not a single non-alphanumeric, non-backslash,
 *   non-whitespace character, or if it is a bracket style delimiter.
 */
function preg_escape(string $pattern, string $delimiter): string
{
    // A delimiter can be any non-alphanumeric, non-backslash, non-whitespace
    // character.
    $matched = preg_match('/^[^[:alnum:]\\\\[:space:](){}\\[\\]<>]$/', $delimiter);
    if (! $matched) {
        assert($matched !== false, preg_last_error_msg());

        if (strlen($delimiter) !== 1) {
            throw new ValueError(
                sprintf(
                    '%s(): Argument #2 ($delimiter) must be a single character',
                    __FUNCTION__,
                ),
            );
        }

        if (str_contains('(){}[]<>', $delimiter)) {
            throw new ValueError(
                sprintf(
                    '%s(): Argument #2 ($delimiter) cannot be a bracket style '
                    . 'delimiter',
                    __FUNCTION__,
                ),
            );
        }

        throw new ValueError(
            sprintf(
                '%s(): Argument #2 ($delimiter) must be a non-alphanumeric, '
                . 'non-backslash, non-whitespace character',
                __FUNCTION__,
            ),
        );
    }

    if (empty($pattern)) {
        return $pattern;
    }

    $pattern = preg_replace(
        '/(?<!\\\\)(?>\\\\\\\\)*\K' . preg_quote($delimiter, '/') . '/',
        '\\\\' . $delimiter,
        $pattern,
    );

    assert($pattern !== null);

    return $pattern;
}
