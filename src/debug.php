<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Debug
 */

declare(strict_types=1);

namespace empaphy\usephul;

use function count;
use function debug_backtrace;

use const DEBUG_BACKTRACE_IGNORE_ARGS;

/**
 * Returns the current stack trace depth.
 *
 * @param  int  $limit
 *   This parameter can be used to limit the number of stack frames scanned.
 *   The default value of `0` will scan all stack frames.
 *
 * @return int
 *   The depth of the current stack trace, optionally limited by __limit__.
 */
function debug_backtrace_depth(int $limit = 0): int
{
    // Under the hood the `debug_backtrace()` function clamps `$limit` to a
    // signed 32-bit integer, so we have to accomodate for that behavior here.

    if ($limit & 0x8000_0000) {
        return 0;
    }

    switch ($limit & 0x7FFF_FFFF) {
        case 0:
            break;
        case 0x7FFF_FFFF:
            $limit -= 0x7FFF_FFFF;
            break;
        default:
            $limit++;
    }

    return count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit)) - 1;
}
