<?php

declare(strict_types=1);

namespace Tests\Unit\other;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\Samples\SampleChildClass;
use Tests\Samples\SampleClass;
use Tests\Samples\SampleParentTrait;
use Tests\Samples\SampleParentTraitUsingTrait;
use Tests\Samples\SampleTraitUsingChildClass;
use Tests\TestCase;

use function empaphy\usephul\class_parents_traits_uses;

#[CoversFunction('empaphy\usephul\class_parents_traits_uses')]
#[UsesFunction('empaphy\usephul\class_traits_uses')]
class ClassParentsTraitsUsesTest extends TestCase
{
    /**
     * @param  object|class-string  $objectOrClass
     * @formatter:off
     */
    #[TestWith([SampleClass::class,                true, []])]
    #[TestWith([SampleChildClass::class,           true, []])]
    #[TestWith([SampleTraitUsingChildClass::class, true, [
        SampleParentTrait::class           => SampleParentTrait::class,
        SampleParentTraitUsingTrait::class => SampleParentTraitUsingTrait::class,
    ]])]
    #[TestWith([new SampleTraitUsingChildClass(), true, [
        SampleParentTrait::class           => SampleParentTrait::class,
        SampleParentTraitUsingTrait::class => SampleParentTraitUsingTrait::class,
    ]])]
    public function testReturnsParentTraits(object|string $objectOrClass, bool $autoload, array $expected): void
    {
        $actual = class_parents_traits_uses($objectOrClass, $autoload);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @formatter:on
     */
    #[TestWith(['NonExistingClassName', true])]
    public function testReturnsFalse(string $class, bool $autoload): void
    {
        $message = sprintf(
            'class_parents(): Class %s does not exist%s',
            $class,
            $autoload ? ' and could not be loaded' : '',
        );
        $this->expectWarning($message);
        $condition = class_parents_traits_uses($class, $autoload); // @phpstan-ignore argument.type
        $this->assertFalse($condition);
    }
}
