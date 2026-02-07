<?php

declare(strict_types=1);

namespace Tests\Unit\other;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Samples\SampleChildTrait;
use Tests\Samples\SampleParentTrait;
use Tests\Samples\SampleParentTraitUsingTrait;
use Tests\Samples\SampleTraitUsingChildClass;
use Tests\Samples\SampleTraitUsingParentClass;
use Tests\TestCase;

use function empaphy\usephul\class_traits_uses;
use function sprintf;

#[CoversFunction('empaphy\usephul\class_traits_uses')]
class ClassTraitUsesTest extends TestCase
{
    /**
     * @param  object|class-string  $objectOrClass
     * @param  array<trait-string, trait-string>  $expected
     * @formatter:off
     */
    #[TestWith([SampleTraitUsingChildClass::class,  true, [SampleChildTrait::class => SampleChildTrait::class]])]
    #[TestWith([new SampleTraitUsingChildClass(),   true, [SampleChildTrait::class => SampleChildTrait::class]])]
    #[TestWith([SampleTraitUsingParentClass::class, true, [
        SampleParentTraitUsingTrait::class => SampleParentTraitUsingTrait::class,
        SampleParentTrait::class           => SampleParentTrait::class,
    ]])]
    #[TestWith([new SampleTraitUsingParentClass(),  true, [
        SampleParentTraitUsingTrait::class => SampleParentTraitUsingTrait::class,
        SampleParentTrait::class           => SampleParentTrait::class,
    ]])]
    public function testReturnsTraitsOfClass(object|string $objectOrClass, bool $autoload, array $expected): void
    {
        $actual = class_traits_uses($objectOrClass, $autoload);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @formatter:on
     * @param  class-string  $class
     */
    #[TestWith(['NonExistingClassName', true])]
    public function testReturnsFalse(string $class, bool $autoload): void
    {
        $message = sprintf(
            'class_uses(): Class %s does not exist%s',
            $class,
            $autoload ? ' and could not be loaded' : '',
        );
        $this->expectWarning($message);
        $condition = class_traits_uses($class, $autoload);
        $this->assertFalse($condition);
    }
}
