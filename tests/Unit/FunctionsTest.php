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

use empaphy\usephul;

describe('array_interchange()', function () {
    it('interchanges array elements', function ($array, $key1, $key2, $expected) {
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

describe('is_closed_resource()', function () {
    it('correctly returns whether value is a closed resource', function ($value, $type) {
        $isClosed = usephul\is_closed_resource($value);
        $expected = usephul\Type::ClosedResource === $type;

        expect($isClosed)->toBe($expected);
    })->with('types / test cases');
});

describe('is_zero()', function () {
    test('returns true if value is (close to) 0', function ($value, $tolerance) {
        $isZero = usephul\is_zero($value, $tolerance);

        expect($isZero)->toBeTrue();
    })->with([
        [0, null],
        [0.0, null],
        [PHP_FLOAT_MIN, usephul\PHP_ZERO_TOLERANCE],
        [PHP_FLOAT_MIN, PHP_FLOAT_MIN],
    ]);

    test('returns false if value is not (close to) 0', function ($value, $tolerance) {
        $isZero = usephul\is_zero($value, $tolerance);

        expect($isZero)->toBeFalse();
    })->with([
        [1, usephul\PHP_ZERO_TOLERANCE],
        [1.0, usephul\PHP_ZERO_TOLERANCE],
        [PHP_FLOAT_EPSILON, PHP_FLOAT_MIN],
        [PHP_FLOAT_MIN, null],
    ]);
});

describe('seq()', function () {
    test('properly sequences values', function ($data, $expected) {
        $array = [];

        foreach (usephul\seq($data) as $key => $value) {
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
