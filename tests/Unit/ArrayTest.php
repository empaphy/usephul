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
