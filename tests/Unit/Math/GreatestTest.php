<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest;

use ArgumentCountError;
use empaphy\usephul\Math;

describe('Math\\greatest()', function () {
    test('should require at least two arguments', function () {
        $this->expectException(ArgumentCountError::class);

        /** @noinspection PhpParamsInspection */
        Math\greatest(1); // @phpstan-ignore arguments.count
    });

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
