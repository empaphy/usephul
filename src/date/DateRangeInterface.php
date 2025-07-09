<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Filesystem
 *
 * @noinspection PhpDocSignatureInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\date;

use DateInterval;
use DatePeriod;
use DateTimeInterface;

/**
 * @property-read TDate $start
 *   The start date of the range.
 *
 * @property-read TEnd $end
 *   The end date of the range.
 *
 * @property-read bool $include_start_date
 *   Whether to compare the start date inclusively.
 *
 * @property-read bool $include_end_date
 *   Whether to compare the end date inclusively.
 *
 * @property-read DateInterval $duration
 *   The duration of the range.
 *
 * @property-read int-mask-of<DateRangeInterface::*> $options
 *   A bit field which can be used to control certain behavior with start-
 *   and end-dates.
 *
 * @template TDate of DateTimeInterface
 * @template TEnd  of DateTimeInterface
 *
 * @phpstan-require-extends DateRangeAbstract
 */
interface DateRangeInterface
{
    /**
     * When comparing the range, make the start date exclusive.
     */
    public const EXCLUDE_START_DATE = DatePeriod::EXCLUDE_START_DATE;

    /**
     * When comparing the range, make the end date inclusive.
     */
    public const INCLUDE_END_DATE = 2; // DatePeriod::INCLUDE_END_DATE;

    /**
     * Gets the start date of the range.
     *
     * @return TDate
     *   Returns an object that implements {@see DateTimeInterface}.
     */
    public function getStartDate(): DateTimeInterface;

    /**
     * Gets the end date of the range.
     *
     * @return TEnd
     *   Returns an object that implements {@see DateTimeInterface}.
     */
    public function getEndDate(): DateTimeInterface;

    /**
     * Gets a DateInterval object representing the duration of the range.
     *
     * @return DateInterval
     *   Returns a {@see DateInterval} object.
     */
    public function getDuration(): DateInterval;

    /**
     * Checks whether the given date range overlaps with this one.
     *
     * @param  self | DatePeriod  $other
     *   The date range to compare with.
     *
     * @return bool
     *   Returns `true` if the date ranges overlap, `false` otherwise.
     */
    public function overlaps(self | DatePeriod $other): bool;

    /**
     * Checks whether the range contains the given date, interval or range.
     *
     * @param  self | DatePeriod | DateInterval | DateTimeInterface  $other
     *   The date or date range to compare with.
     *
     * @return bool
     *   Returns `true` if the date range (fully) contains the given date or
     *   date range, `false` otherwise.
     */
    public function contains(
        self | DatePeriod | DateInterval | DateTimeInterface $other,
    ): bool;
}
