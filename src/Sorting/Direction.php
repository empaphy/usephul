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

/**
 * Sorting direction.
 */
enum Direction: int
{
    use EnumDynamicity;

    /**
     * Sorts in ascending order.
     *
     * For example:
     * - numbers are sorted from smaller to larger numbers. (-1, 0, 1, 2, …)
     * - strings are sorted in alphabetical order. (A, B, C, …, X, Y, Z)
     */
    case Ascending = +1;

    /**
     * Sorts in descending order.
     *
     * For example:
     * - numbers are sorted from larger to smaller numbers. (2, 1, 0, -1, …)
     * - strings are sorted in reverse alphabetical order. (Z, Y, X, …, C, B, A)
     */
    case Descending = -1;
}
