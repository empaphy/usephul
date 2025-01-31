<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays\Sorting
 */

declare(strict_types=1);

namespace empaphy\rephine\Sorting;

use empaphy\rephine\Enumerations\EnumDynamicity;

/**
 * Sorting type flags: used by various sort functions.
 */
enum Type: int
{
    use EnumDynamicity;

    /**
     * Compare items normally.
     */
    case Regular = SORT_REGULAR;

    /**
     * Sort strings normally, case-insensitively.
     */
    case RegularCaseInsensitive = SORT_REGULAR | SORT_FLAG_CASE;

    /**
     * Compare items numerically.
     */
    case Numeric = SORT_NUMERIC;

    /**
     * Compare items as strings.
     */
    case String = SORT_STRING;

    /**
     * Compare items as strings, case-insensitively.
     */
    case StringCaseInsensitive = SORT_STRING | SORT_FLAG_CASE;

    /**
     * Compare items as strings, based on the current locale.
     */
    case LocaleString = SORT_LOCALE_STRING;

    /**
     * Compare items as strings using "natural ordering" like `natsort()`.
     */
    case Natural = SORT_NATURAL;
}
