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

describe('array_remap()', function () {

    test('yields from generators', function (array $map) {
        $remap = usephul\array_remap(
            fn($key, $value) => yield $value => $key,
            $map,
        );

        expect($remap)->toEqual(array_flip($map));
    })->with([
        [
            'map' => [
                'foo' => 'FOO',
                'bar' => 'BAR',
            ],
        ],
    ]);

    test('yields from callable', function (array $expected, array $map) {
        $remap = usephul\array_remap(
            fn($key, $value) => $key,
            $map,
        );

        expect($remap)->toEqual($expected);
    })->with([
        [
            'expected' => [
                'foo' => 'foo',
                'bar' => 'bar',
            ],
            'map' => [
                'foo' => 'FOO',
                'bar' => 'BAR',
            ],
        ],
    ]);

});
