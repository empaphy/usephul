<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\Math;

use ArgumentCountError;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use empaphy\usephul\Math;

describe('Math', function () {
    describe('greatest()', function () {
        test('requires at least two arguments', function () {
            /** @noinspection PhpParamsInspection */
            Math\greatest(1); // @phpstan-ignore arguments.count
        })->throws(ArgumentCountError::class);

        test('returns the greatest value', function ($a, $b, $expected) {
            $greatest = Math\greatest($a, $b);
            expect($greatest)->toBe($expected);
        })->with([
            [1, 2, 2],
            [2, 1, 2],
            [1, 1, 1],
            // TODO: add more cases
        ]);
    });

    describe('least()', function () {
        test('should require at least two arguments', function () {
            /** @noinspection PhpParamsInspection */
            Math\least(1); // @phpstan-ignore arguments.count
        })->throws(ArgumentCountError::class);

        test('returns the least of given values', function ($a, $b, $expected) {
            $least = Math\least($a, $b);

            expect($least)->toBe($expected);
        })->with([
            [1, 2, 1],
            [2, 1, 1],
            [1, 1, 1],
            // TODO: add more cases
        ]);
    });

    describe('rank()', function () {
        test('converts DateTime related objects to seconds as float', function () {
            $start = new DateTimeImmutable();
            $interval = new DateInterval('P1D');
            $end = (new DateTimeImmutable())->add(new DateInterval('P2D'));
            $datePeriod = new DatePeriod($start, $interval, $end);

            $monoStart = Math\rank($start);
            $monoInterval = Math\rank($interval);
            $monoEnd = Math\rank($end);
            $monoPeriod = Math\rank($datePeriod);

            expect($monoStart)->toBeFloat()
                ->and($monoInterval)->toBeFloat()
                ->and($monoEnd)->toBeFloat()
                ->and($monoPeriod)->toBeFloat();
        });
    });
});
