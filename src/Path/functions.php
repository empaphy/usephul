<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Paths
 */

declare(strict_types=1);

namespace empaphy\usephul\Path;

use ValueError;

use function array_reverse;
use function assert;
use function implode;
use function is_string;
use function pathinfo;
use function preg_quote;
use function preg_replace;
use function sprintf;
use function str_contains;
use function strlen;
use function strrpos;
use function substr;

use const DIRECTORY_SEPARATOR;
use const PATHINFO_EXTENSION;
use const PATHINFO_FILENAME;

/**
 * Returns the trailing name component of a given path.
 *
 * Given a string containing the __path__ to a file or directory, this
 * function will return the trailing name component.
 *
 * > __Note__:
 * >
 * > {@see basename()} operates naively on the input string, and is not
 * > aware of the actual filesystem, or path components such as "..".
 *
 * > __Caution__:
 * > {@see basename()} is locale-aware, so for it to see the correct
 * > basename with multibyte character paths, the matching locale must be
 * > set using the {@see setlocale()} function. If __path__ contains
 * > characters which are invalid for the current locale, the behavior of
 * > {@see basename()} is undefined.
 *
 * @param  string  $path
 *   A path.
 *
 *   On Windows, both slash (`/`) and backslash (`\`) are used as directory
 *   separator characters. In other environments, it is the forward slash
 *   (`/`).
 *
 * @param  string  $suffix
 *   If the name component ends in __suffix__, this will also be cut off.
 *
 * @return string
 *   Returns the base name of the given path.
 *
 * @see dirname() - Returns a parent directory's path
 * @see extension() - Returns extension component of a path
 * @see filename() - Returns basename of a path, without extension
 * @see pathinfo() - Returns information about a file path
 */
function basename(string $path, string $suffix = ''): string
{
    return \basename($path, $suffix);
}

/**
 * Returns an array of path components for the given path.
 *
 * Empty components (i.e., successive directory separators) are disregarded.
 * Additionally, path seperators at the start or end of __path__ are also
 * disregarded.
 *
 * For example:
 *
 *     components('foo/bar');    // Will return ['foo', 'bar']
 *     components('/foo//bar/'); // Will return ['foo', 'bar']
 *     components('/');          // Will return ['']
 *     components('');           // Will return [''];
 *
 * > __Note__:
 * >
 * > {@see components()} operates naively on the input string, and is not aware
 * > of the actual filesystem, or path components such as "..".
 *
 * > __Caution__:
 * > {@see components()} is locale-aware, so for it to see the correct basename
 * > with multibyte character paths, the matching locale must be set using
 * > the {@see setlocale()} function. If __path__ contains characters which
 * > are invalid for the current locale, the behavior of {@see components()} is
 * > undefined.
 *
 * > __Caution__:
 * > This function behaves differently on Windows compared to *nix.
 * >
 * >     components('\\');   // Will return [''] on Windows and ['\'] on *nix.
 * >     components('C:\\'); // Will return [''] on Windows and ['C:\'] on *nix.
 * >
 *
 * @param  string  $path
 *   A path to split into its components.
 *
 *   On Windows, both slash (`/`) and backslash (`\`) are used as directory
 *   separator characters. In other environments, it is the forward slash (`/`).
 *
 * @return (
 *   $path is empty ? array{} : (
 *   $path is "." ? array{''} : (
 *   $path is "/" ? array{''} : (
 *   non-empty-array<non-empty-string>
 * ))))
 *   An array containing the __path__ split up into its components.
 */
function components(string $path): array
{
    if (empty($path)) {
        return [];
    }

    $components = [];

    do {
        $last = $path;
        $path = \dirname($last);
        $component = \basename($last);

        if ('.' === $component) {
            continue;
        }

        $components[] = $component;
    } while (! (
        empty($path)
        || '.' === $path
        || '/' === $path
        || DIRECTORY_SEPARATOR === $path
        || $last === $path
    ));

    if (empty($components)) {
        return [''];
    }

    return array_reverse($components);
}

/**
 * Returns the directory separator used in the given path, supported by the
 * current platform.
 *
 * @param  string  $path
 *   Path for which to determine the directory separator.
 *
 * @param  non-empty-string  $directory_separator
 *   By default, this is set to {@see DIRECTORY_SEPARATOR}, but you can override
 *   it for testing purposes.
 *
 * @return non-empty-string
 */
function directory_separator(
    string $path,
    /** @internal */
    string $directory_separator = DIRECTORY_SEPARATOR,
): string {
    if ('' === $directory_separator) {
        throw new ValueError(
            'Argument #2 ($directory_separator) must not be empty',
        );
    }

    if ('/' === $directory_separator) {
        return '/';
    }

    if (str_contains($path, $directory_separator)) {
        return $directory_separator;
    }

    if (str_contains($path, '/')) {
        return '/';
    }

    return $directory_separator;
}

/**
 * Returns a parent directory's path.
 *
 * Given a string containing the path of a file or directory, this function
 * will return the parent directory's path that is __levels__ up from the
 * current directory.
 *
 * > __Note__:
 * >
 * > {@see dirname()} operates naively on the input string, and is not
 * > aware of the actual filesystem, or path components such as "..".
 *
 * > __Caution__:
 * > On Windows, {@see dirname()} assumes the currently set codepage, so
 * > for it to see the correct directory name with multibyte character
 * > paths, the matching codepage must be set. If __path__ contains
 * > characters which are invalid for the current codepage, the behavior
 * > of {@see dirname()} is undefined.
 * >
 * > On other systems, {@see dirname()} assumes __path__ to be encoded in
 * > an ASCII compatible encoding. Otherwise, the behavior of the function
 * > is undefined.
 *
 * @param  string  $path
 *   A path.
 *
 *   On Windows, both slash (`/`) and backslash (`\`) are used as directory
 *   separator characters. In other environments, it is the forward slash
 *   (`/`).
 *
 * @param  int<1, max>  $levels
 *   The number of parent directories to go up.
 *
 *   This must be an integer greater than 0.
 *
 * @return string
 *   Returns the path of a parent directory. If there are no slashes in
 *   __path__, a dot ('`.`') is returned, indicating the current directory.
 *   Otherwise, the returned string is __path__ with any trailing
 *   `/component` removed.
 *
 *   > __Caution__:
 *   > Be careful when using this function in a loop that can reach the
 *   > top-level directory as this can result in an infinite loop.
 *   >
 *   >     <?php
 *   >     dirname('.');    // Will return '.'.
 *   >     dirname('/');    // Will return `\` on Windows and '/' on *nix.
 *   >     dirname('\\');   // Will return `\` on Windows and '.' on *nix.
 *   >     dirname('C:\\'); // Will return 'C:\' on Windows and '.' on *nix.
 *   >     ?>
 *
 * @see basename() - Returns trailing name component of a path
 * @see pathinfo() - Returns information about a file path
 * @see realpath() - Returns canonicalized absolute pathname
 */
function dirname(string $path, int $levels = 1): string
{
    return \dirname($path, $levels);
}

/**
 * Returns the extension component of a given path without the extension.
 *
 * Given a string containing the path to a file or directory, this function
 * will return the extension component.
 *
 *     extension('/root/dir/sub/name.suf.ext'); // returns 'ext'
 *     extension('/root/dir/sub/name.ext');     // returns 'ext'
 *     extension('/root/dir/sub/.ext');         // returns 'ext'
 *     extension('/root/dir/sub/name');         // returns ''
 *     extension('/root/dir/sub/');             // returns ''
 *
 * > __Note__:
 * >
 * > If the __path__ has more than one extension, {@see extension()}
 * > returns only the last one.
 *
 * > __Note__:
 * >
 * > {@see extension()} operates naively on the input string, and is not
 * > aware of the actual filesystem, or path components such as "..".
 *
 * > __Caution__
 * > {@see extension()} is locale-aware, so for it to parse a path
 * > containing multibyte characters correctly, the matching locale must
 * > be set using the {@see setlocale()} function.
 *
 * @param  string  $path
 *   A path.
 *
 * @return string
 *   The extension component of __path__. If the path has no extension
 *   component, an empty string is returned.
 *
 * @see dirname() - Returns a parent directory's path
 * @see basename() - Returns trailing name component of a path
 * @see filename() - Returns basename of a path, without extension
 * @see pathinfo() - Returns information about a file path
 */
function extension(string $path): string
{
    return pathinfo($path, PATHINFO_EXTENSION);
}

/**
 * Replace the extension of a path with a new value.
 *
 * If __replacement__ is left empty, the extension is removed from __path__,
 * _including_ the seperating period (`.`).
 *
 * For the intents of this function, __path__ is considered to have an extension
 * if there is a period (`.`) which is not the first character of the basename.
 *
 * @param  string  $path
 *   A path.
 *
 * @param  null|string  $replacement
 *   The replacement extension. If `null`, the extension is removed along with
 *   the preceding period (`.`).
 *
 * @param  string  $suffix
 *   If the filename in __path__ is suffixed with __suffix__, then the suffix
 *   is also replaced along with the extension. Additionally, if __suffix__
 *   contains an extension – i.e. starts with a period (`.`) – then it will
 *   always be replaced in __path__, even if the value of __path__ starts with
 *   __suffix__.
 *
 * @param  non-empty-string  $directory_separator
 *   By default, this is set to {@see DIRECTORY_SEPARATOR}, but you can override
 *   it for testing purposes.
 *
 * @return ($path is '' ? '' : string)
 *   The modified path.
 */
function extension_replace(
    string  $path,
    ?string $replacement = null,
    string  $suffix = '',
    string  $directory_separator = DIRECTORY_SEPARATOR,
): string {
    if ('' === $path) {
        return $path;
    }

    $delimiter = '/';
    $separators = [preg_quote('/', $delimiter)];
    if ($directory_separator !== '/') {
        $separators[] = preg_quote($directory_separator, $delimiter);
    }

    $sep = implode('', $separators);
    $start = implode('|', $separators);
    $match = "((?<!^|$start))\.[^.$sep]*";

    if ($suffix) {
        $pre = preg_quote($suffix, $delimiter);
        $match = "(?:$pre)?$match";

        if (str_contains($suffix, '.')) {
            $match = "(?:$pre|$match)";
        }
    }

    $path = preg_replace(
        "$delimiter$match([$sep]?)$$delimiter",
        null === $replacement ? '\\1\\2' : "\\1.$replacement\\2",
        $path,
    );

    assert(null !== $path);

    return $path;
}

/**
 * Returns the name component of a given path without the extension.
 *
 * Given a string containing the path to a file or directory, this function
 * will return the trailing name component without the extension.
 *
 *     filename('/root/dir/sub/name.suf.ext'); // returns 'name.suf'
 *     filename('/root/dir/sub/name.ext');     // returns 'name'
 *     filename('/root/dir/sub/name');         // returns 'name'
 *     filename('/root/dir/sub/.ext');         // returns ''
 *     filename('/root/dir/sub/');             // returns 'sub'
 *
 *     filename('/root/dir/sub/name.suf.ext', '.ext') // returns 'name.suf'
 *     filename('/root/dir/sub/name.suf.ext', '.suf') // returns 'name'
 *     filename('/root/dir/sub/name.suf.suf', '.suf') // returns 'name'
 *     filename('/root/dir/sub/name.ext',     '.suf') // returns 'name'
 *     filename('/root/dir/sub/name.suf',     '.suf') // returns 'name'
 *     filename('/root/dir/sub/name',         '.suf') // returns 'name'
 *     filename('/root/dir/sub/.suf.ext',     '.suf') // returns ''
 *     filename('/root/dir/sub/',             '.suf') // returns 'sub'
 *     filename('/root/dir/sub/',             'sub')  // returns ''
 *
 * > __Note__:
 * >
 * > If the path has more than one extension, {@see filename()} only strips
 * > the last one.
 *
 * > __Note__:
 * >
 * > {@see filename()} operates naively on the input string, and is not
 * > aware of the actual filesystem, or path components such as "..".
 *
 * > __Caution__
 * > {@see filename()} is locale-aware, so for it to parse a path containing
 * > multibyte characters correctly, the matching locale must be set using
 * > the {@see setlocale()} function.
 *
 * @param  string  $path
 *   A path.
 *
 * @param  string  $suffix
 *   If the name component ends in __suffix__, this will also be cut off.
 *
 * @return string
 *   Returns the name component of __path__.
 *
 * @see dirname() - Returns a parent directory's path
 * @see basename() - Returns trailing name component of a path
 * @see extension() - Returns extension component of a path
 * @see pathinfo() - Returns information about a file path
 */
function filename(string $path, string $suffix = ''): string
{
    $filename = pathinfo($path, PATHINFO_FILENAME);

    if ('' !== $suffix) {
        $suffix_len = strlen($suffix);

        if (substr($filename, -$suffix_len) === $suffix) {
            return substr($filename, 0, -$suffix_len);
        }
    }

    return $filename;
}

/**
 * Returns a suffix for the given path based on a given set of separators.
 *
 * A suffix is defined as the part of the basename after the last separator
 * character in __separators__, and before the extension.
 *
 *     suffix('/path/to/name-suf',     '-'); // returns '-suf'
 *     suffix('/path/to/name-suf.ext', '-'); // returns '-suf'
 *     suffix('/path/to/name.suf.ext', '.'); // returns '.suf'
 *
 * @param  string  $path
 *   A path.
 *
 * @param  string  $separator
 *   Specifies the separator strings.
 *
 * @param  string  ...$separators
 *   Specifies additional separator strings.
 *
 * @return string
 */
function suffix(
    string $path,
    string $separator = '-',
    string ...$separators,
): string {
    if (empty($separator)) {
        throw new ValueError('Argument #2 ($separator) must not be empty');
    }

    $filename = pathinfo($path, PATHINFO_FILENAME);
    $offset = strrpos($filename, $separator);

    $i = 2;
    foreach ($separators as $key => $sep) {
        $i++;
        if (empty($sep)) {
            throw new ValueError(
                sprintf(
                    'Argument #%d (...$separators[%s]) must not be empty',
                    $i,
                    is_string($key) ? "'$key'" : $key,
                ),
            );
        }

        $offset = strrpos($filename, $sep, (int) $offset) ?: $offset;
    }

    return false === $offset ? '' : substr($filename, $offset);
}

/**
 * Replace a suffix in a path with a new value.
 *
 * If __replacement__ is left empty, the suffix is removed from __path__.
 *
 * @param  string  $path
 *   A path.
 *
 * @param  string  $suffix
 *   The new suffix. If empty, the suffix is removed.
 *
 * @param  string  ...$separators
 *   You can provide multiple separator strings to identify the existing suffix.
 *   If no separator is provided, the suffix will simply be added to the
 *   filename component of the __path__.
 *
 * @return string
 *   The modified path.
 */
function suffix_replace(
    string $path,
    string $suffix,
    string ...$separators,
): string {
    $pathinfo = pathinfo($path);

    $filename = $pathinfo['filename'];
    $extension = $pathinfo['extension'] ?? null;
    $dir = $pathinfo['dirname'] ?? '';

    $offset = null;

    $i = 2;
    foreach ($separators as $key => $separator) {
        $i++;
        if (empty($separator)) {
            throw new ValueError(
                sprintf(
                    'Argument #%d (...$separators[%s]) must not be empty',
                    $i,
                    is_string($key) ? "'$key'" : $key,
                ),
            );
        }

        $offset = strrpos($filename, $separator, (int) $offset)
            ?: $offset ?? false;
    }

    $filename = match ($offset) {
        null    => $filename . $suffix,
        false   => $filename,
        default => substr($filename, 0, $offset) . $suffix,
    };

    $directory_separator = null;
    if (str_contains($path, DIRECTORY_SEPARATOR)) {
        $directory_separator = DIRECTORY_SEPARATOR;
    } elseif (str_contains($path, '/')) {
        $directory_separator = '/'; // @codeCoverageIgnore
    }

    if ('.' === $dir && null === $directory_separator) {
        $dir = '';
    } else {
        $dir .= $directory_separator;
    }

    return $dir . $filename . (null !== $extension ? ".$extension" : '');
}
