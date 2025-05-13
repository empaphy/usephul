<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul\math;

describe('var\\\\rank()', function () {
    test('converts DateTime related objects to seconds as float', function () {
        $start = new DateTimeImmutable();
        $interval = new DateInterval('P1D');
        $end = (new DateTimeImmutable())->add(new DateInterval('P2D'));
        $datePeriod = new DatePeriod($start, $interval, $end);

        $monoStart = math\rank($start);
        $monoInterval = math\rank($interval);
        $monoEnd = math\rank($end);
        $monoPeriod = math\rank($datePeriod);

        expect($monoStart)->toBeFloat();
        expect($monoInterval)->toBeFloat();
        expect($monoEnd)->toBeFloat();
        expect($monoPeriod)->toBeFloat();
    });
});
