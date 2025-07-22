<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\usephul
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\generators;

use empaphy\usephul\generators;

describe('generators', function () {
    describe('seq()', function () {
        test('properly sequences values', function ($data, $expected) {
            $array = [];

            foreach (generators\seq($data) as $key => $value) {
                $array[$key] = $value;
            }

            expect($array)->toBe($expected);
        })->with([
            'true  => [true]'          => [true, [true]],
            'false => [false]'         => [false, [false]],
            'null  => [null]'          => [null, [null]],
            '1     => [1]'             => [1, [1]],
            '"1"   => [1]'             => ['1', ['1']],
            '"abc" => ["a", "b", "c"]' => ['abc', ['a', 'b', 'c']],
            '[1, 2, 3] => [1, 2, 3]'   => [[1, 2, 3], [0 => 1, 1 => 2, 2 => 3]],
            '{a: 1, b: 2} => ["a" => 1, "b" => 2]' => [(object) ['a' => 1, 'b' => 2], ['a' => 1, 'b' => 2]],
        ]);
    });
});
