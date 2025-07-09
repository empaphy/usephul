<?php

/**
 * @noinspection MultipleExpectChainableInspection
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul\date;

describe('DateRange', function () {
    test('constructed with DateTimeImmutable as end', function () {
        $start    = new DateTimeImmutable('2001-03-06 13:19:27');
        $end      = new DateTimeImmutable('2002-05-09 18:26:38');
        $interval = $start->diff($end);

        $range = new date\DateRange($start, $end);

        expect($range->start)->toEqual($start);
        expect($range->end)->toEqual($end);
        expect($range->duration)->toEqual($interval);
    });

    test('constructed with DateInterval as end', function () {
        $start    = new DateTimeImmutable('2001-03-06 13:19:27');
        $end      = new DateTimeImmutable('2002-05-09 18:26:38');
        $interval = $start->diff($end);

        $range = new date\DateRange($start, $interval);

        expect($range->start)->toEqual($start);
        expect($range->end)->toEqual($end);
        expect($range->duration)->toEqual($interval);
    });

    test('created from ISO8601 string', function () {
        $specification = '2008-03-01T13:00:00Z/P1Y2M10DT2H30M';
        /** @noinspection PhpParamsInspection */
        $datePeriod = (PHP_VERSION_ID >= 80300)
            ? DatePeriod::createFromISO8601String("R1/{$specification}")
            : new DatePeriod("R1/{$specification}");

        $expectedInterval = $datePeriod->interval;
        $expectedStart    = $datePeriod->start;
        $expectedEnd      = $expectedStart->add($expectedInterval);

        $range = date\DateRange::createFromISO8601String($specification);

        expect($range->start)->toEqual($expectedStart);
        expect($range->end)->toEqual($expectedEnd);
        expect($range->duration)->toEqual($expectedInterval);
        expect($range->getStartDate())->toEqual($expectedStart);
        expect($range->getEndDate())->toEqual($expectedEnd);
        expect($range->getDateInterval())->toEqual($expectedInterval);
    });
});
