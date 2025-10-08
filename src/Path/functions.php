<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Paths
 */

declare(strict_types=1);

namespace empaphy\usephul\Path;

use function explode;
use function implode;
use function pathinfo;
use function preg_quote;
use function preg_replace;
use function str_contains;
use function strlen;
use function substr;

use const DIRECTORY_SEPARATOR;
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
 * Empty components are represented as `null`. This includes the first empty
 * component if the __path__ starts with a directory separator. For example:
 *
 *     components('foo/bar')    === ['foo', 'bar'];
 *     components('/foo//bar/') === [null, 'foo', null, 'bar', null];
 *     components('/')          === [null, null];
 *     components('')           === [null];
 *
 * > __Note__:
 * >
 * > {@see components()} operates naively on the input string, and is not
 * > aware of the actual filesystem, or path components such as "..".
 *
 * On other systems, dirname() assumes path to be encoded in an ASCII compatible encoding. Otherwise, the behavior of the function is undefined.
 *
 * @param  string  $path
 *   A path to split into its components.
 *
 *   On Windows, both slash (`/`) and backslash (`\`) are used as directory
 *   separator characters. In other environments, it is the forward slash (`/`).
 *
 * @return non-empty-list<non-empty-string|null>
 *   An array containing the __path__ split up into its components.
 */
function components(string $path): array
{
    $components = [];

    if ('/' === DIRECTORY_SEPARATOR) {
        foreach (explode('/', $path) as $v) {
            $components[] = '' === $v ? null : $v;
        }
    } else {
        foreach (explode('/', $path) as $v) {
            foreach (explode(DIRECTORY_SEPARATOR, $v) as $u) {
                $components[] = '' === $u ? null : $u;
            }
        }
    }

    return $components;
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
 * @param  string  $prefix
 *   If __path__ contains an extension that is preceeded by __prefix__, then
 *   __prefix__ is also replaced along with the extension.
 *   Additionally, if __prefix__ contains an extension – i.e. contains a
 *   period (`.`) – then it will always be replaced in __path__, even if
 *   the value of __path__ starts with __prefix__.
 *
 * @return ($path is '' ? '' : string)
 *   The modified path.
 */
function extension_replace(
    string $path,
    ?string $replacement = null,
    string $prefix = '',
): string {
    if ('' === $path) {
        return $path;
    }

    $separators = [preg_quote('/', '/')];
    if (DIRECTORY_SEPARATOR !== '/') {
        $separators[] = preg_quote(DIRECTORY_SEPARATOR, '/');
    }

    $sep = implode('', $separators);
    $start = implode('|', $separators);
    $match = "((?<!^|$start))\.[^.$sep]*";

    if ($prefix) {
        $pre = preg_quote($prefix, '/');
        $match = "(?:$pre)?$match";

        if (str_contains($prefix, '.')) {
            $match = "(?:$pre|$match)";
        }
    }

    return preg_replace(
        "/$match([$sep]?)$/",
        null === $replacement ? '\\1\\2' : "\\1.$replacement\\2",
        $path,
    );
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
