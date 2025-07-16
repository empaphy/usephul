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
