<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\tests\Unit\array;

use empaphy\usephul;

describe('array_interchange()', function () {
    test('interchanges array elements', function ($array, $key1, $key2, $expected) {
        $result = usephul\array_interchange($array, $key1, $key2);

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

describe('array_remap()', function () {
    test('yields from generators', function ($map) {
        $remap = usephul\array_remap(
            fn ($key, $value) => yield $value => $key,
            $map
        );

        expect($remap)->toEqual(array_flip($map));
    })->with([
        [
            [ // map
                'foo' => 'FOO',
                'bar' => 'BAR',
            ]
        ]
    ]);

    test('yields from callable', function ($expected, $map) {
        $remap = usephul\array_remap(
            fn ($key, $value) => $key,
            $map
        );

        expect($remap)->toEqual($expected);
    })->with([
        [
            [ // expected
               'foo' => 'foo',
               'bar' => 'bar',
            ],
            [ // map
               'foo' => 'FOO',
               'bar' => 'BAR',
            ]
        ]
    ]);
});

describe('array_zip()', function () {
    test('zips arrays', function ($expected, ...$arguments) {
        $zippedArray = usephul\array_zip(...$arguments);

        expect($zippedArray)->toBe($expected);
    })->with([
        'single array' => [
            [['foo'], ['bar']],
            ['foo', 'bar'],
        ],
        'multiple arrays' => [
            [
                ['foo', 'jantje', 'spam'],
                ['bar', 'pietje', 'ham'],
                [null, 'hansje', 'eggs'],
                [null, 'henkje', null],
            ],
            ['foo', 'bar'],
            ['jantje', 'pietje', 'hansje', 'henkje'],
            ['spam', 'ham', 'eggs'],
        ],
    ]);
});
