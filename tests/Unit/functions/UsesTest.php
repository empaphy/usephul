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
    trait SuperMockTrait {}

    trait MockTrait
    {
        use SuperMockTrait;
    }

    trait ParentSuperMockTrait {}

    trait ParentMockTrait
    {
        use ParentSuperMockTrait;
    }

    trait OtherMockTrait {}

    class DoesntUseTrait {}

    class UsesMockTrait
    {
        use MockTrait;
    }

    class ParentClassUsesParentMockTrait
    {
        use ParentMockTrait;
    }

    class ClassExtendsParentClass extends ParentClassUsesParentMockTrait {}

    class ClassExtendsParentClassUsesOtherMockTrait extends ParentClassUsesParentMockTrait
    {
        use OtherMockTrait;
    }

    test('returns true when a class uses a specific trait', function () {
        $class = UsesMockTrait::class;
        $uses = usephul\uses($class, MockTrait::class);
        $usesOther = usephul\uses($class, OtherMockTrait::class);

        expect($uses)->toBeTrue()
            ->and($usesOther)->toBeFalse();
    });

    test('returns false when a class does not use a trait', function () {
        $class = DoesntUseTrait::class;
        $uses = usephul\uses($class, MockTrait::class);
        $usesOther = usephul\uses($class, OtherMockTrait::class);

        expect($uses)->toBeFalse()
            ->and($usesOther)->toBeFalse();
    });

    test('returns false with a class while allow_string = false', function () {
        $class = UsesMockTrait::class;
        $object = new $class();
        $classUses = usephul\uses($class, MockTrait::class, false);
        $objectUses = usephul\uses($object, MockTrait::class, false);

        expect($classUses)->toBeFalse()
            ->and($objectUses)->toBeTrue();
    });

    test('returns true when an object uses a specific trait', function () {
        $object = new UsesMockTrait();
        $uses = usephul\uses($object, MockTrait::class);
        $usesOther = usephul\uses($object, OtherMockTrait::class);

        expect($uses)->toBeTrue()
            ->and($usesOther)->toBeFalse();
    });

    test('returns false when an object does not use a trait', function () {
        $object = new UsesMockTrait();
        $uses = usephul\uses($object, OtherMockTrait::class);

        expect($uses)->toBeFalse();
    });

    test('returns true when a parent class uses a trait', function () {
        $class = ClassExtendsParentClass::class;
        $object = new $class();
        $classUses = usephul\uses($class, ParentMockTrait::class);
        $objectUses = usephul\uses($object, ParentMockTrait::class);

        expect($classUses)->toBeTrue()
            ->and($objectUses)->toBeTrue();
    });

    test("returns true when a class' with a parent class that uses another trait", function () {
        $class = ClassExtendsParentClassUsesOtherMockTrait::class;
        $object = new $class();
        $classUses = usephul\uses($class, OtherMockTrait::class);
        $objectUses = usephul\uses($object, OtherMockTrait::class);
        $classUsesParent = usephul\uses($class, ParentMockTrait::class);
        $objectUsesParent = usephul\uses($object, ParentMockTrait::class);

        expect($classUses)->toBeTrue()
            ->and($classUsesParent)->toBeTrue()
            ->and($objectUses)->toBeTrue()
            ->and($objectUsesParent)->toBeTrue();
    });

    test("returns true when a class' trait uses a trait", function () {
        $class = ParentClassUsesParentMockTrait::class;
        $object = new $class();
        $classUses = usephul\uses($class, ParentSuperMockTrait::class);
        $objectUses = usephul\uses($object, ParentSuperMockTrait::class);

        expect($classUses)->toBeTrue()
            ->and($objectUses)->toBeTrue();
    });
});
