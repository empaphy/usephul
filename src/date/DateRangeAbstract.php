<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Filesystem
 *
 * @noinspection ProperNullCoalescingOperatorUsageInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\date;

abstract class DateRangeAbstract
{
    /**
     * @param  bool  $include_start_date
     *   Whether to compare the start date inclusively.
     *
     * @param  bool  $include_end_date
     *   Whether to compare the end date inclusively.
     */
    protected function __construct(
        public readonly bool $include_start_date = true,
        public readonly bool $include_end_date = false,
    ) {}
}
