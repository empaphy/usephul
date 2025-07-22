<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection PhpIllegalPsrClassPathInspection
 */

declare(strict_types=1);

namespace Pest\Unit\other;

use empaphy\usephul;

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

class ParentClassUsesParentMockTrait
{
    use ParentMockTrait;
}

class MockClass extends ParentClassUsesParentMockTrait
{
    use MockTrait;
}

describe('class_parents_uses()', function () {
    test("returns traits of class' parent class", function () {
        $class = MockClass::class;
        $object = new $class();
        $classParentsUses = usephul\class_parents_uses($class);
        $objectParentsUses = usephul\class_parents_uses($object);

        $expected = [
            ParentMockTrait::class => ParentMockTrait::class,
        ];

        expect($classParentsUses)->toEqual($expected)
            ->and($objectParentsUses)->toEqual($expected);
    });
});

describe('class_parents_traits_uses()', function () {
    test("returns traits of class' parent class", function () {
        $class = MockClass::class;
        $object = new $class();
        $classParentsUses = usephul\class_parents_traits_uses($class);
        $objectParentsUses = usephul\class_parents_traits_uses($object);

        $expected = [
            ParentSuperMockTrait::class => ParentSuperMockTrait::class,
            ParentMockTrait::class      => ParentMockTrait::class,
        ];

        expect($classParentsUses)->toEqual($expected)
            ->and($objectParentsUses)->toEqual($expected);
    });
});

describe('class_traits_uses()', function () {
    test("returns traits of class", function () {
        $class = MockClass::class;
        $object = new $class();
        $classParentsUses = usephul\class_traits_uses($class);
        $objectParentsUses = usephul\class_traits_uses($object);

        $expected = [
            SuperMockTrait::class => SuperMockTrait::class,
            MockTrait::class      => MockTrait::class,
        ];

        expect($classParentsUses)->toEqual($expected)
            ->and($objectParentsUses)->toEqual($expected);
    });
});
