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

namespace Pest\Unit\Var;

use empaphy\usephul\Var\Type;

describe('Var', function () {
    describe('Type', function () {
        test('has the appropriate cases', function ($case, $expected) {
            expect($case->value)->toBe($expected);
        })->with('types / values');
    });

    describe('Type::of()', function () {
        test('returns appropriate Type', function ($value, $expected) {
            $type = Type::of($value);

            expect($type)->toBe($expected);
        })->with('types / test cases');

        test("doesn't return wrong Type", function ($value, $unexpected) {
            $type = Type::of($value);

            expect($type)->not()->toBe($unexpected);
        })->with('types / fail cases');
    });

    describe('Type::tryOf()', function () {
        test('returns appropriate Type', function ($value, $expected) {
            $type = Type::tryOf($value);

            expect($type)->toBe($expected);
        })->with('types / test cases');

        test("doesn't return wrong Type", function ($value, $unexpected) {
            $type = Type::tryOf($value);

            expect($type)->not()->toBe($unexpected);
        })->with('types / fail cases');
    });

    describe('Type->is()', function () {
        test('returns true when type matches', function ($value, Type $type) {
            expect($type->is($value))->toBeTrue();
        })->with('types / test cases');

        test('returns false', function ($value, Type $type) {
            expect($type->is($value))->toBeFalse();
        })->with('types / fail cases');
    });
});
