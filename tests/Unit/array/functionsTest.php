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
use empaphy\usephul\Var\Type;

use function array_flip;

describe('array_exclude()', function () {
    test('excludes values from an array', function (array $array, array $values, $expected) {
        $picked = usephul\array_exclude($array, ...$values);
        expect($picked)->toEqual($expected);
    })->with([[
        'array'    => [ 'foo' => 'FOO', 'bar' => 'BAR', 'qux' => null ],
        'values'   => [                          'BAR',          null ],
        'expected' => [ 'foo' => 'FOO'                                ],
    ]]);
});

describe('array_extract()', function () {
    test('extracts values from an array', function (array $array, array $values, $expected) {
        $picked = usephul\array_extract($array, ...$values);
        expect($picked)->toEqual($expected);
    })->with([[
        'array'    => [ 'foo' => 'FOO', 'bar' => 'BAR', 'qux' => null ],
        'values'   => [          'FOO'                                ],
        'expected' => [ 'foo' => 'FOO'                                ],
    ]]);
});

describe('array_interchange()', function () {
    test('interchanges array elements', function (
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

describe('array_key_types()', function () {
    test('returns array key types', function (array $array, array $expected) {
        $types = usephul\array_key_types($array);
        expect($types)->toBe($expected);
    })->with([
        ['array' => [],                               'expected' => []],
        ['array' => [         'FOO',          'BAR'], 'expected' => [Type::INTEGER => true]],
        ['array' => [  37  => 'FOO',   42  => 'BAR'], 'expected' => [Type::INTEGER => true]],
        ['array' => ['foo' => 'FOO', 'bar' => 'BAR'], 'expected' => [Type::STRING  => true]],
        ['array' => ['foo' => 'FOO',   42  => 'BAR'], 'expected' => [Type::INTEGER => true, Type::STRING => true]],
    ]);
});

describe('array_omit()', function () {
    test('omits keys from an array', function (array $array, array $keys, $expected) {
        $picked = usephul\array_omit($array, ...$keys);
        expect($picked)->toEqual($expected);
    })->with([[
        'array'    => [ 'foo' => 'FOO', 'bar' => 'BAR', 'qux' => null ],
        'keys'     => [                 'bar'         , 'qux'         ],
        'expected' => [ 'foo' => 'FOO',                               ],
    ]]);
});

describe('array_pick()', function () {
    test('picks keys from an array', function (array $array, array $keys, $expected) {
        $picked = usephul\array_pick($array, ...$keys);
        expect($picked)->toEqual($expected);
    })->with([[
        'array'    => [ 'foo' => 'FOO', 'bar' => 'BAR', 'qux' => null ],
        'keys'     => [                 'bar'         , 'qux'         ],
        'expected' => [                 'bar' => 'BAR', 'qux' => null ],
    ]]);
});

describe('array_remap()', function () {
    test('yields from generators', function (array $map) {
        $remap = usephul\array_remap(
            fn($key, $value) => yield $value => $key,
            $map,
        );
        expect($remap)->toEqual(array_flip($map));
    })->with([[
        'map' => [ 'foo' => 'FOO', 'bar' => 'BAR' ],
    ]]);

    test('yields from callable', function (array $map, array $expected) {
        $remap = usephul\array_remap(
            fn($key, $value) => $key,
            $map,
        );
        expect($remap)->toEqual($expected);
    })->with([[
        'map'      => [ 'foo' => 'FOO', 'bar' => 'BAR' ],
        'expected' => [ 'foo' => 'foo', 'bar' => 'bar' ],
    ]]);
});

describe('array_zip()', function () {
    test('zips arrays', function (array $arrays = [], array $expected = []) {
        /** @var  array<array> $arrays */
        $zippedArray = usephul\array_zip(...$arrays);
        expect($zippedArray)->toBe($expected);
    })->with([
        'single array' => [
            'arrays'   => [['foo'  ,  'bar']],
            'expected' => [['foo'] , ['bar']],
        ],

        'multiple arrays' => [
            'arrays' => [
                [ 'foo'    , 'bar'                          ],
                [ 'jantje' , 'pietje' , 'hansje' , 'henkje' ],
                [ 'spam'   , 'ham'    , 'eggs'              ],
            ],
            'expected' => [
                [ 'foo' , 'jantje' , 'spam' ],
                [ 'bar' , 'pietje' , 'ham'  ],
                [ null  , 'hansje' , 'eggs' ],
                [ null  , 'henkje' , null   ],
            ],
        ],

        'single assoc array' => [
            'arrays' => [
                [ 'FOO'  => 'foo'    , 'BAR'  => 'bar'                                              ],
                [ 'JAN'  => 'jantje' , 'PIET' => 'pietje' , 'HANS' => 'hansje' , 'HENK' => 'henkje' ],
                [ 'SPAM' => 'spam'   , 'HAM'  => 'ham'    , 'EGGS' => 'eggs'                        ],
            ],
            'expected' => [
                [ 'foo' , 'jantje' , 'spam' ],
                [ 'bar' , 'pietje' , 'ham'  ],
                [ null  , 'hansje' , 'eggs' ],
                [ null  , 'henkje' , null   ],
            ],
        ],
    ]);
});
