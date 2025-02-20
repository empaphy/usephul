<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Arrays
 */

declare(strict_types=1);

namespace empaphy\usephul\Array;

enum FilterMode: int
{
    private const USE_VALUE = 0;
    private const USE_BOTH  = ARRAY_FILTER_USE_BOTH;
    private const USE_KEY   = ARRAY_FILTER_USE_KEY;

    /**
     * Is used with {@see Map::filter()} to pass value as the only argument
     * to the given callback function.
     */
    case UseValue = self::USE_VALUE;

    /**
     * Is used with {@see Map::filter()} to pass both value and key to the
     * given callback function.
     */
    case UseBoth = self::USE_BOTH;

    /**
     * Is used with {@see Map::filter()} to pass each key as the first argument
     * to the given callback function.
     */
    case UseKey = self::USE_KEY;
}
