<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul\Sorting\Direction;

describe('Sorting Direction enum', function () {
    test('has correct values', function (Direction $direction, $expected) {
        expect($direction->value)->toBe($expected);
    })->with([
        Direction::Ascending->name  => [Direction::Ascending,  +1],
        Direction::Descending->name => [Direction::Descending, -1],
    ]);
});
