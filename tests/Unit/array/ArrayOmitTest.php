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

describe('array_omit()', function () {
    test('omits keys from array', function ($expected, array $array, array $keys) {
        $picked = usephul\array_omit($array, ...$keys);
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
            'keys' => ['bar', 'qux'],
        ]
    ]);
});