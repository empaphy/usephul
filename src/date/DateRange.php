<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Filesystem
 */

declare(strict_types=1);

namespace empaphy\usephul\date;

use DateInterval;
use DateMalformedPeriodStringException;
use DatePeriod;
use DateTimeInterface;

use const PHP_VERSION_ID;

/**
 * @template TDate of DateTimeInterface
 * @template TEnd  of DateTimeInterface
 *
 * @implements DateRangeInterface<TDate, TEnd>
 */
class DateRange extends DateRangeAbstract implements DateRangeInterface
{
    /**
     * @param  TDate  $start
     *   The start date of the range.
     *
     * @param  TEnd|DateInterval  $end
     *   The end date of the period. May also be an interval used as ofset
     *   from the start date.
     *
     * @param  value-of<DatePeriod::*>  $options
     *   A bit field which can be used to control certain behaviour with
     *   start- and end-dates.
     *
     * @noinspection PhpDocSignatureInspection
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function __construct(
        public DateTimeInterface $start,
        public DateTimeInterface|DateInterval $end,
        $options = 0,
    ) {
        if ($end instanceof DateTimeInterface) {
            parent::__construct($start, $start->diff($end), $end, $options);
        } else {
            parent::__construct($start, $end, $start->add($end), $options);
        }
    }

    /**
     * @param  string  $specification
     *   A subset of the ISO 8601 repeating interval specification.
     *
     *   An example of an accepted ISO 8601 interval specification is
     *   `2008-03-01T13:00:00Z/P1Y2M10DT2H30M`, which specifies:
     *
     *     - Starting at `2008-03-01T13:00:00Z`.
     *     - A 1 year, 2 months, 10 days, 2 hours, and 30 minute interval
     *       (`/P1Y2M10DT2H30M`).
     *
     *   An example of an ISO 8601 interval specification feature that PHP
     *   does not support is time offsets other than UTC (`Z`), such as
     *   `+02:00`.
     *
     * @param  value-of<DatePeriod::*>  $options
     *   A bit field which can be used to control certain behaviour with start-
     *   and end-dates.
     *
     * @return static
     *   Creates a new DateRange object.
     *
     * @throws DateMalformedPeriodStringException
     * @noinspection PhpDocSignatureInspection
     */
    public static function createFromISO8601String(
        string $specification,
        int $options = 0,
    ): static {
        if ('R' !== $specification[0]) {
            $specification = "R1/{$specification}";
        }

        $datePeriod = (PHP_VERSION_ID >= 80300)
            ? parent::createFromISO8601String($specification, $options)
            : new DatePeriod($specification, $options);

        return new static(
            $datePeriod->getStartDate(),
            $datePeriod->getDateInterval(),
            $options,
        );
    }
}
