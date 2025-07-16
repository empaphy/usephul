<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul;

describe('array_exclude()', function () {
    test('omits keys from array', function ($expected, array $array, array $values) {
        $picked = usephul\array_exclude($array, ...$values);
        expect($picked)->toEqual($expected);
    })->with([
        [
            'expected' => [
                'foo' => 'FOO',
            ],
            'array' => [
                'foo' => 'FOO',
                'bar' => 'BAR',
                'qux' => null,
            ],
            'values' => ['BAR', null],
        ]
    ]);
});