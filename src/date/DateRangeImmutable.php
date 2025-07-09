<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Filesystem
 *
 * @noinspection PhpDocFieldTypeMismatchInspection
 * @noinspection ProperNullCoalescingOperatorUsageInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\date;

use DateInterval;
use DateMalformedPeriodStringException;
use DatePeriod;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Override;

use const PHP_VERSION_ID;

/**
 * @implements DateRangeInterface<DateTimeImmutable, DateTimeImmutable>
 */
class DateRangeImmutable extends DateRangeAbstract implements DateRangeInterface
{
    /**
     * The start date of the range.
     */
    public readonly DateTimeImmutable $start;

    /**
     * The end date of the range.
     */
    public readonly DateTimeImmutable $end;

    /**
     * The duration of the range.
     */
    public readonly DateInterval $duration;

    /**
     * @param  DateTimeInterface  $start
     *   The start date of the range.
     *
     * @param  DateTimeInterface | DateInterval  $end
     *   The end date of the range. May also be an interval used as ofset
     *   from the start date.
     *
     * @param  int-mask-of<DateRangeInterface::*>  $options
     *   A bit field which can be used to control certain behavior with
     *   start- and end-dates.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public function __construct(
        DateTimeInterface                $start,
        DateTimeInterface | DateInterval $end,
        int $options = 0,
    ) {
        parent::__construct(
            include_start_date: ! ($options & self::EXCLUDE_START_DATE),
            include_end_date: (bool) ($options & self::EXCLUDE_START_DATE),
        );

        if (! $start instanceof DateTimeImmutable) {
            $start = $start instanceof DateTime
                ? DateTimeImmutable::createFromMutable($start)
                : DateTimeImmutable::createFromInterface($start);
        }

        if ($end instanceof DateInterval) {
            $duration = $end;
            $end = $start->add($duration);
        } else {
            if (! $end instanceof DateTimeImmutable) {
                $end = $end instanceof DateTime
                    ? DateTimeImmutable::createFromMutable($end)
                    : DateTimeImmutable::createFromInterface($end);
            }
            $duration = $start->diff($end);
        }

        $this->start = $start;
        $this->end = $end;
        $this->duration = $duration;
    }

    /**
     * @template TDateRange of DateRangeInterface | DatePeriod
     *
     * @param  TDateRange  $object
     * @return (TDateRange is self ? TDateRange : self)
     *
     * @noinspection PhpDocSignatureInspection
     */
    public static function createFrom(
        DateRangeInterface | DatePeriod $object,
    ): self {
        if ($object instanceof self) {
            return $object;
        }

        return new DateRangeImmutable(
            $object->getStartDate(),
            $object instanceof DatePeriod
                ? $object->getEndDate() ?? $object->getDateInterval()
                : $object->getEndDate(),
            ! $object->include_start_date & self::EXCLUDE_START_DATE
            | $object->include_end_date   & self::INCLUDE_END_DATE,
        );
    }

    /**
     * @param  string  $specification
     *   A subset of the ISO 8601 repeating interval specification.
     *
     *   An example of an accepted ISO 8601 interval specification is
     *   `2008-03-01T13:00:00Z/P1Y2M10DT2H30M`, which specifies:
     *
     *     - Starting at `2008-03-01T13:00:00Z`.
     *     - A 1 year, 2 months, 10 days, 2 hours, and 30-minute interval
     *       (`/P1Y2M10DT2H30M`).
     *
     *   An example of an ISO 8601 interval specification feature that PHP
     *   does not support is time offsets other than UTC (`Z`), such as
     *   `+02:00`.
     *
     * @param  int-mask-of<DateRangeInterface::*>  $options
     *   A bit field which can be used to control certain behavior with start-
     *   and end-dates.
     *
     * @return self
     *   Creates a new DateRange object.
     *
     * @throws DateMalformedPeriodStringException
     */
    final public static function createFromISO8601String(
        string $specification,
        int $options = 0,
    ): self {
        if ('R' !== $specification[0]) {
            $specification = "R1/{$specification}";
        }

        $datePeriod = (PHP_VERSION_ID >= 80300)
            ? DatePeriod::createFromISO8601String($specification, $options)
            : new DatePeriod($specification, $options);

        return static::createFrom($datePeriod);
    }

    /**
     * @return \DateTimeImmutable
     */
    #[Override]
    public function getStartDate(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return \DateTimeImmutable
     */
    #[Override]
    public function getEndDate(): DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @return \DateInterval
     */
    #[Override]
    public function getDuration(): DateInterval
    {
        return $this->duration;
    }

    /**
     * Checks whether the given date range overlaps with this one.
     *
     * @param  DateRangeInterface | DatePeriod  $other
     *   The date range to compare with.
     *
     * @return bool
     *   Returns `true` if the date ranges overlap, `false` otherwise.
     */
    #[Override]
    public function overlaps(DateRangeInterface | DatePeriod $other): bool
    {
        $a = $this->include_start_date && $other->include_end_date
            ? $this->start <= $other->getEndDate()
            : $this->start <  $other->getEndDate();
        $b = $this->include_end_date && $other->include_start_date
            ? $this->end >= $other->getStartDate()
            : $this->end >  $other->getStartDate();

        return $a && $b;
    }

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
    #[Override]
    public function contains(
        DateRangeInterface|DatePeriod|DateInterval|DateTimeInterface $other,
    ): bool {
        if (
            $other instanceof DateRangeInterface || $other instanceof DatePeriod
        ) {
            $a = $this->include_start_date && $other->include_start_date
                ? $this->start <= $other->getStartDate()
                : $this->start <  $other->getStartDate();
            $b = $this->include_end_date && $other->include_end_date
                ? $this->end >= $other->getEndDate()
                : $this->end >  $other->getEndDate();

            return $a && $b;
        }

        if ($other instanceof DateInterval) {
            $other = $this->start->add($other);
        }

        $a = $this->include_start_date
            ? $this->start <= $other
            : $this->start <  $other;
        $b = $this->include_end_date
            ? $this->end >= $other
            : $this->end >  $other;

        return $a && $b;
    }
}
