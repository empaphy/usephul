<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Filesystem
 */

declare(strict_types=1);

namespace empaphy\usephul\Filesystem;

/**
 * Provides information about a file path.
 *
 * > **Note**:
 * >
 * > {@see PathInfo} operates naively on the **path** string, and is not aware
 * > of the actual filesystem, or path components such as "..".
 *
 * > **Caution**
 * > {@see PathInfo} is locale aware, so for it to parse a path containing
 * > multibyte characters correctly, the matching locale must be set using the
 * > setlocale() function.
 */
class PathInfo
{
    /**
     * The path of the directory or file.
     */
    public readonly string|null $dirname;

    /**
     * The name of the directory or the name and extension of the file.
     */
    public readonly string $basename;

    /**
     * The extension of the file.
     */
    public readonly string|null $extension;

    /**
     * The name of the file (without the extension) or directory.
     */
    public readonly string $filename;

    /**
     * @param  string  $path  The path to be parsed.
     */
    public function __construct(public readonly string $path)
    {
        $pathinfo = \pathinfo($path);

        $this->dirname   = $pathinfo['dirname'] ?? null;
        $this->basename  = $pathinfo['basename'];
        $this->extension = $pathinfo['extension'] ?? null;
        $this->filename  = $pathinfo['filename'];
    }
}
