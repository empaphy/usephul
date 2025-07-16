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

describe('Math\\least()', function () {
    test('should require at least two arguments', function () {
        $this->expectException(ArgumentCountError::class);

        /** @noinspection PhpParamsInspection */
        Math\least(1);
    });

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
