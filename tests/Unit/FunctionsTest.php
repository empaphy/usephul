<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\rephine
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\rephine;

describe('array_interchange()', function () {
    it('interchanges array elements', function ($array, $key1, $key2, $expected) {
        $result = rephine\array_interchange($array, $key1, $key2);

        expect($result)->toBe($expected);
    })->with([
        'integer keys and values' => [
            [3, 5, 7, 11, 13], // $array
            1,                 // $key1
            3,                 // $key2
            [3, 11, 7, 5, 13], // $expected
        ],

        'string keys and values' => [
            [                   // $array
                'foo' => 0xF00,
                'bar' => 0x8A9,
                'bat' => 0x8A7,
                'baz' => 0x8A2,
                'fuz' => 0xF42,
            ],
            'bar',              // $key1
            'baz',              // $key2
            [                   // $expected
                'foo' => 0xF00,
                'bar' => 0x8A2,
                'bat' => 0x8A7,
                'baz' => 0x8A9,
                'fuz' => 0xF42,
            ],
        ],

        'wrong key' => [
            [3, 5, 7],       // $array
            1,               // $key1
            3,               // $key2
            [3, null, 7, 5], // $expected
        ],
    ]);
});
