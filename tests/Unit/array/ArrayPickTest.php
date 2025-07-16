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

describe('array_pick()', function () {
    test('picks keys from array', function ($expected, array $array, array $keys) {
        $picked = usephul\array_pick($array, ...$keys);
        expect($picked)->toEqual($expected);
    })->with([
        [
            'expected' => [
                'bar' => 'BAR',
                'qux' => null,
            ],
            'array' => [
                'foo' => 'FOO',
                'bar' => 'BAR',
                'qux' => null,
            ],
            'keys' => ['bar', 'qux'],
        ]
    ]);
});