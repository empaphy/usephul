<?php

declare(strict_types=1);

namespace Tests\Unit\other;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Samples\SampleChildClass;
use Tests\Samples\SampleClass;
use Tests\Samples\SampleParentTraitUsingTrait;
use Tests\Samples\SampleTraitUsingChildClass;
use Tests\TestCase;

use function empaphy\usephul\class_parents_uses;
use function sprintf;

#[CoversFunction('empaphy\usephul\class_parents_uses')]
class ClassParentsUsesTest extends TestCase
{
    /**
     * @formatter:off
     */
    #[TestWith([new SampleClass(),                 true, []])]
    #[TestWith([new SampleChildClass(),            true, []])]
    #[TestWith([SampleTraitUsingChildClass::class, true, [
        SampleParentTraitUsingTrait::class => SampleParentTraitUsingTrait::class,
    ]])]
    #[TestWith([new SampleTraitUsingChildClass(), true, [
        SampleParentTraitUsingTrait::class => SampleParentTraitUsingTrait::class,
    ]])]
    public function testReturnsTraitsOfParentClass(object|string $objectOrClass, bool $autoload, array $expected): void
    {
        $actual = class_parents_uses($objectOrClass, $autoload);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @formatter:on
     */
    #[TestWith(['NonExistingClassName', true])]
    public function testReturnsFalse(
        string $class,
        bool   $autoload,
    ): void {
        $message = sprintf(
            'class_parents(): Class %s does not exist%s',
            $class,
            $autoload ? ' and could not be loaded' : '',
        );
        $this->expectWarning($message);
        $condition = class_parents_uses($class, $autoload);
        $this->assertFalse($condition);
    }
}
