<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul\Math;

describe('Math\\rank()', function () {
    test('converts DateTime related objects to seconds as float', function () {
        $start = new DateTimeImmutable();
        $interval = new DateInterval('P1D');
        $end = (new DateTimeImmutable())->add(new DateInterval('P2D'));
        $datePeriod = new DatePeriod($start, $interval, $end);

        $monoStart = Math\rank($start);
        $monoInterval = Math\rank($interval);
        $monoEnd = Math\rank($end);
        $monoPeriod = Math\rank($datePeriod);

        expect($monoStart)->toBeFloat();
        expect($monoInterval)->toBeFloat();
        expect($monoEnd)->toBeFloat();
        expect($monoPeriod)->toBeFloat();
    });
});
