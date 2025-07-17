<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays\Sorting
 */

declare(strict_types=1);

namespace empaphy\usephul\Sorting;

use empaphy\usephul\Enumerations\EnumDynamicity;

use const SORT_FLAG_CASE;
use const SORT_LOCALE_STRING;
use const SORT_NATURAL;
use const SORT_NUMERIC;
use const SORT_REGULAR;
use const SORT_STRING;

/**
 * Sorting type flags: used by various sort functions.
 */
enum Type: int
{
    use EnumDynamicity;

    private const REGULAR = SORT_REGULAR;

    private const REGULAR_CASE_INSENSITIVE = SORT_REGULAR | SORT_FLAG_CASE;

    private const NUMERIC = SORT_NUMERIC;

    private const STRING = SORT_STRING;

    private const STRING_CASE_INSENSITIVE = SORT_STRING | SORT_FLAG_CASE;

    private const LOCALE_STRING = SORT_LOCALE_STRING;

    private const NATURAL = SORT_NATURAL;

    /**
     * Compare items normally.
     */
    case Regular = self::REGULAR;

    /**
     * Sort strings normally, case-insensitively.
     */
    case RegularCaseInsensitive = self::REGULAR_CASE_INSENSITIVE;

    /**
     * Compare items numerically.
     */
    case Numeric = self::NUMERIC;

    /**
     * Compare items as strings.
     */
    case String = self::STRING;

    /**
     * Compare items as strings, case-insensitively.
     */
    case StringCaseInsensitive = self::STRING_CASE_INSENSITIVE;

    /**
     * Compare items as strings, based on the current locale.
     */
    case LocaleString = self::LOCALE_STRING;

    /**
     * Compare items as strings using "natural ordering" like `natsort()`.
     */
    case Natural = self::NATURAL;
}
