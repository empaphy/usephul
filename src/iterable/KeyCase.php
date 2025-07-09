<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul\iterable;

/**
 * Is used with Map::changeKeyCase() to convert array keys to a specific case.
 *
 * As of PHP 8.2.0, only ASCII characters will be converted.
 */
enum KeyCase: int
{
    private const LOWER = CASE_LOWER;
    private const UPPER = CASE_UPPER;

    /**
     * Convert array keys to lower case.
     *
     * This is also the default case for {@see ArrayMap::changeKeyCase()}.
     */
    case Lower = self::LOWER;

    /**
     * Convert array keys to upper case.
     */
    case Upper = self::UPPER;
}
