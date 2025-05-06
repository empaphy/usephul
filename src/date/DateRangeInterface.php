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
 * @template TDate of DateTimeInterface
 * @template TEnd of DateTimeInterface
 *
 * @property-read TDate $start
 *   The start date of the range.
 *
 * @property-read TEnd $end
 *   End of the TimeRange.
 *
 * @property-read ?DateInterval $interval
 *   Duration of the TimeRange.
 *
 * @phpstan-require-extends DatePeriod<TDate, TEnd>
 */
interface DateRangeInterface
{
    /**
     * Gets a DateInterval object representing the duration of the range.
     *
     * @return DateInterval
     *   Returns a {@see DateInterval} object.
     */
    public function getDateInterval(): DateInterval;

    /**
     * Gets the end date of the range.
     *
     * @return TEnd|null
     *   Returns `null` if the range does not have an end date.
     *
     *   Returns a {@see DateTimeImmutable} object when the range is initialized
     *   with a {@see DateTimeImmutable} object as the end parameter.
     *
     *   Returns a cloned {@see DateTime} object representing the end date
     *   otherwise.
     */
    public function getEndDate(): ?DateTimeInterface;

    /**
     * Gets the start date of the range.
     *
     * @return TDate|null
     *   Returns a {@see DateTimeImmutable} object when the range is initialized
     *   with a {@see DateTimeImmutable} object as the start parameter.
     *
     *   Returns a {@see DateTime} object otherwise.
     */
    public function getStartDate(): DateTimeInterface;
}
