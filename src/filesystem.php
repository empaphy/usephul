<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Filesystem
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * Returns the name component of path without the extension.
 *
 * Given a string containing the path to a file or directory, this function will
 * return the trailing name component without the extension.
 *
 * > **Note**:
 * >
 * > If the path has more than one extension, **filename()** only strips the
 * > last one.
 *
 * > **Note**:
 * >
 * > **filename()** operates naively on the input string, and is not aware of
 * > the actual filesystem, or path components such as "..".
 *
 * > **Caution**
 * > **filename()** is locale aware, so for it to parse a path containing
 * > multibyte characters correctly, the matching locale must be set using the
 * > {@see setlocale()} function.
 *
 * ## See Also
 *
 *   - {@see dirname()} - Returns a parent directory's path
 *   - {@see basename()} - Returns trailing name component of path
 *   - {@see extension()} - Returns extension component of path
 *   - {@see pathinfo()} - Returns information about a file path
 *
 * @param  string  $path    A path.
 * @param  string  $suffix  If the name component ends in **suffix** this will
 *                          also be cut off.
 * @return string
 */
function filename(string $path, string $suffix = ''): string
{
    $filename = \pathinfo($path, \PATHINFO_FILENAME);

    if ('' !== $suffix) {
        $suffix_len = \strlen($suffix);

        if (\substr($filename, -$suffix_len) === $suffix) {
            return \substr($filename, 0, -$suffix_len);
        }
    }

    return $filename;
}

/**
 * Returns the extension component of path without the extension.
 *
 * Given a string containing the path to a file or directory, this function will
 * return the extension component.
 *
 * > **Note**:
 * >
 * > If the **path** has more than one extension **extension()** returns only
 * > the last one.
 *
 * > **Note**:
 * >
 * > **extension()** operates naively on the input string, and is not aware of
 * > the actual filesystem, or path components such as "..".
 *
 * > **Caution**
 * > **extension()** is locale aware, so for it to parse a path containing
 * > multibyte characters correctly, the matching locale must be set using the
 * > {@see setlocale()} function.
 *
 * ## See Also
 *
 *   - {@see dirname()} - Returns a parent directory's path
 *   - {@see basename()} - Returns trailing name component of path
 *   - {@see filename()} - Returns basename of path, without extension
 *   - {@see pathinfo()} - Returns information about a file path
 *
 * @param  string  $path  A path.
 * @return string
 */
function extension(string $path): string
{
    return \pathinfo($path, PATHINFO_EXTENSION);
}
