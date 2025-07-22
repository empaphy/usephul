<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\array;

use empaphy\usephul;
use Throwable;

describe('array_interchange()', function () {

    test('interchanges array elements when called', function (
        array $array,
        int|string $key1,
        int|string $key2,
        array $expected,
    ) {
        $result = usephul\array_interchange($array, $key1, $key2);
        expect($result)->toBe($expected);
    })->with([
        'integer keys and values' => [
            'array'    => [3, 5, 7, 11, 13],
            'key1'     => 1,
            'key2'     => 3,
            'expected' => [3, 11, 7, 5, 13],
        ],

        'string keys and values' => [
            'array'    => [
                'foo' => 0xF00,
                'bar' => 0x8A9,
                'bat' => 0x8A7,
                'baz' => 0x8A2,
                'fuz' => 0xF42,
            ],
            'key1'     => 'bar',
            'key2'     => 'baz',
            'expected' => [
                'foo' => 0xF00,
                'bar' => 0x8A2,
                'bat' => 0x8A7,
                'baz' => 0x8A9,
                'fuz' => 0xF42,
            ],
        ],
    ]);

    test('replaces elements with null if the replacement key doesn\'t exist', function () {
        $result = usephul\array_interchange([3, 5, 7], 1, 3);

        expect($result[1])->toBeNull();
    });

});
