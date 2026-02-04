<?php

declare(strict_types=1);

namespace Tests\Unit\Type;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\Samples\SampleChildTrait;
use Tests\Samples\SampleClass;
use Tests\Samples\SampleParentTrait;
use Tests\Samples\SampleParentTraitUsingTrait;
use Tests\Samples\SampleTraitInheritingChildClass;
use Tests\Samples\SampleTraitUsingChildClass;
use Tests\Samples\SampleTraitUsingClass;
use Tests\Samples\SampleTraitUsingParentClass;
use Tests\Samples\SampleTraitUsingTrait;
use Tests\TestCase;

use function empaphy\usephul\Type\uses;

#[CoversFunction('empaphy\usephul\Type\uses')]
#[UsesFunction('empaphy\usephul\class_parents_traits_uses')]
#[UsesFunction('empaphy\usephul\class_traits_uses')]
class UsesTest extends TestCase
{
    public function testReturnsTrueWhenAClassUsesASpecificTrait(): void
    {
        $class = SampleTraitUsingClass::class;
        $uses = uses($class, SampleTraitUsingTrait::class);
        $usesOther = uses($class, SampleChildTrait::class);

        $this->assertTrue($uses);
        $this->assertFalse($usesOther);
    }

    public function testReturnsFalseWhenAClassDoesNotUseATrait(): void
    {
        $class = SampleClass::class;
        $uses = uses($class, SampleTraitUsingTrait::class);
        $usesOther = uses($class, SampleChildTrait::class);

        $this->assertFalse($uses);
        $this->assertFalse($usesOther);
    }

    public function testReturnsFalseWithAClassWhileAllowStringFalse(): void
    {
        $class = SampleTraitUsingClass::class;
        $object = new $class();
        $classUses = uses($class, SampleTraitUsingTrait::class, false);
        $objectUses = uses($object, SampleTraitUsingTrait::class, false);

        $this->assertFalse($classUses);
        $this->assertTrue($objectUses);
    }

    public function testReturnsTrueWhenAnObjectUsesASpecificTrait(): void
    {
        $object = new SampleTraitUsingClass();
        $uses = uses($object, SampleTraitUsingTrait::class);
        $usesOther = uses($object, SampleChildTrait::class);

        $this->assertTrue($uses);
        $this->assertFalse($usesOther);
    }

    public function testReturnsFalseWhenAnObjectDoesNotUseATrait(): void
    {
        $object = new SampleTraitUsingClass();
        $uses = uses($object, SampleChildTrait::class);

        $this->assertFalse($uses);
    }

    public function testReturnsTrueWhenAParentClassUsesATrait(): void
    {
        $class = SampleTraitInheritingChildClass::class;
        $object = new $class();
        $classUses = uses($class, SampleParentTraitUsingTrait::class);
        $objectUses = uses($object, SampleParentTraitUsingTrait::class);

        $this->assertTrue($classUses);
        $this->assertTrue($objectUses);
    }

    public function testReturnsTrueWhenAClassWithAParentClassThatUsesAnotherTrait(): void
    {
        $class = SampleTraitUsingChildClass::class;
        $object = new $class();
        $classUses = uses($class, SampleChildTrait::class);
        $objectUses = uses($object, SampleChildTrait::class);
        $classUsesParent = uses($class, SampleParentTraitUsingTrait::class);
        $objectUsesParent = uses($object, SampleParentTraitUsingTrait::class);

        $this->assertTrue($classUses);
        $this->assertTrue($classUsesParent);
        $this->assertTrue($objectUses);
        $this->assertTrue($objectUsesParent);
    }

    public function testReturnsTrueWhenAClassTraitUsesATrait(): void
    {
        $class = SampleTraitUsingParentClass::class;
        $object = new $class();
        $classUses = uses($class, SampleParentTrait::class);
        $objectUses = uses($object, SampleParentTrait::class);

        $this->assertTrue($classUses);
        $this->assertTrue($objectUses);
    }
}
