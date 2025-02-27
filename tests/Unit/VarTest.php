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

use empaphy\usephul\var;

describe('is_closed_resource()', function () {
    it('correctly returns whether value is a closed resource', function ($value, $type) {
        $isClosed = var\is_closed_resource($value);
        $expected = var\Type::ClosedResource === $type;

        expect($isClosed)->toBe($expected);
    })->with('types / test cases');
});

describe('is_negative_int()', function () {
    test('returns true', function ($value) {
        $result = var\is_negative_int($value);

        expect($result)->toBeTrue();
    })->with([[-1]]);

    test('returns false', function ($value) {
        $result = var\is_negative_int($value);

        expect($result)->toBeFalse();
    })->with([
        [0],
        [1],
        [-0.1],
        ['-1'],
        [[-1]],
        [new stdClass()],
        [null],
    ]);
});

describe('is_non_empty_string()', function() {
    test('returns true', function ($value) {
        $result = var\is_non_empty_string($value);

        expect($result)->toBeTrue();
    })->with([
        ['foo']
    ]);

    test('returns false', function ($value) {
        $result = var\is_non_empty_string($value);

        expect($result)->toBeFalse();
    })->with([
        [1],
        [0.1],
        [['foo']],
        [new stdClass()],
        [''],
        [null],
        [[]],
    ]);
});

describe('is_number()', function () {
    test('returns true', function ($value) {
        $result = var\is_number($value);

        expect($result)->toBeTrue();
    })->with([
        [1],
        [0],
        [-1],
        [0.1],
        [\NAN],
    ]);

    test('returns false', function ($value) {
        $result = var\is_number($value);

        expect($result)->toBeFalse();
    })->with([
        ['1'],
        ['0'],
        ['-1'],
        [new stdClass()],
        [null],
        [[]],
    ]);
});

describe('is_non_negative_int()', function () {
    test('returns true', function ($value) {
        $result = var\is_non_negative_int($value);

        expect($result)->toBeTrue();
    })->with([
        [0],
        [1],
    ]);

    test('returns false', function ($value) {
        $result = var\is_non_negative_int($value);

        expect($result)->toBeFalse();
    })->with([
        [-1],
        [1.0],
        ['1'],
        [[1]],
        [new stdClass()],
        [null],
    ]);
});

describe('is_non_positive_int()', function () {
    test('returns true', function ($value) {
        $result = var\is_non_positive_int($value);

        expect($result)->toBeTrue();
    })->with([
        [0],
        [-1],
    ]);

    test('returns false', function ($value) {
        $result = var\is_non_positive_int($value);

        expect($result)->toBeFalse();
    })->with([
        [1],
        [-1.0],
        ['-1'],
        [[-1]],
        [new stdClass()],
        [null],
    ]);
});

describe('is_non_zero_int()', function () {
    test('returns true', function ($value) {
        $result = var\is_non_zero_int($value);

        expect($result)->toBeTrue();
    })->with([
        [1],
        [-1],
    ]);

    test('returns false', function ($value) {
        $result = var\is_non_zero_int($value);

        expect($result)->toBeFalse();
    })->with([
        [0],
        [1.0],
        ['1'],
        [[1]],
        [new stdClass()],
        [null],
    ]);
});

describe('is_positive_int()', function () {
    test('returns true', function ($value) {
        $result = var\is_positive_int($value);

        expect($result)->toBeTrue();
    })->with([[1]]);

    test('returns false', function ($value) {
        $result = var\is_positive_int($value);

        expect($result)->toBeFalse();
    })->with([
        [0],
        [-1],
        [0.1],
        ['1'],
        [[1]],
        [new stdClass()],
        [null],
    ]);
});

describe('is_zero()', function () {
    test('returns true if value is (close to) 0', function ($value, $tolerance) {
        $isZero = var\is_zero($value, $tolerance);

        expect($isZero)->toBeTrue();
    })->with([
        [0, null],
        [0.0, null],
        [PHP_FLOAT_MIN, var\PHP_ZERO_TOLERANCE],
        [PHP_FLOAT_MIN, PHP_FLOAT_MIN],
    ]);

    test('returns false if value is not (close to) 0', function ($value, $tolerance) {
        $isZero = var\is_zero($value, $tolerance);

        expect($isZero)->toBeFalse();
    })->with([
        [1, var\PHP_ZERO_TOLERANCE],
        [1.0, var\PHP_ZERO_TOLERANCE],
        [PHP_FLOAT_EPSILON, PHP_FLOAT_MIN],
        [PHP_FLOAT_MIN, null],
    ]);
});
