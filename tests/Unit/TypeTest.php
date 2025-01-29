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

use empaphy\rephine\Type;

describe('Type', function () {
    it('has the appropriate cases', function ($case, $expected) {
        expect($case->value)->toBe($expected);
    })->with('types / values');
});

describe('Type::of()', function () {
    it('returns appropriate Type when called', function ($value, $expected) {
        $type = Type::of($value);

        expect($type)->toBe($expected);
    })->with('types / test cases');

    it("doesn't return wrong Type when called", function ($value, $unexpected) {
        $type = Type::of($value);

        expect($type)->not()->toBe($unexpected);
    })->with('types / fail cases');
});

describe('Type::tryOf()', function () {
    it('returns appropriate Type when called', function ($value, $expected) {
        $type = Type::tryOf($value);

        expect($type)->toBe($expected);
    })->with('types / test cases');

    it("doesn't return wrong Type when called", function ($value, $unexpected) {
        $type = Type::tryOf($value);

        expect($type)->not()->toBe($unexpected);
    })->with('types / fail cases');
});

describe('Type->is()', function () {
    it('returns true when type matches', function ($value, Type $type) {
        expect($type->is($value))->toBeTrue();
    })->with('types / test cases');

    it('returns false when called', function ($value, Type $type) {
        expect($type->is($value))->toBeFalse();
    })->with('types / fail cases');
});
