<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\tests\Unit\functions\UsesTest;

use empaphy\usephul;

describe('uses()', function () {
    trait MockTrait {}

    trait OtherMockTrait {}

    class UsesMockTrait
    {
        use MockTrait;
    }

    test('returns true when a class uses a trait', function () {
        $class = UsesMockTrait::class;
        $uses = usephul\uses($class, MockTrait::class);

        expect($uses)->toBeTrue();
    });

    test('returns false when a class does not use a trait', function () {
        $class = UsesMockTrait::class;
        $uses = usephul\uses($class, OtherMockTrait::class);

        expect($uses)->toBeFalse();
    });

    test('returns false with a class while allow_string = false', function () {
        $class = UsesMockTrait::class;
        $uses = usephul\uses($class, MockTrait::class, false);

        expect($uses)->toBeFalse();
    });

    test('returns true when an object uses a trait', function () {
        $object = new UsesMockTrait();
        $uses = usephul\uses($object, MockTrait::class);

        expect($uses)->toBeTrue();
    });

    test('returns false when an object does not use a trait', function () {
        $object = new UsesMockTrait();
        $uses = usephul\uses($object, OtherMockTrait::class);

        expect($uses)->toBeFalse();
    });

    test('returns true with an object while allow_string = false', function () {
        $object = new UsesMockTrait();
        $uses = usephul\uses($object, MockTrait::class, false);

        expect($uses)->toBeTrue();
    });
});
