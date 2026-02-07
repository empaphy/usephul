<?php

declare(strict_types=1);

namespace Tests\Unit\Type;

use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\Samples\SampleAttributeTargetChildClass;
use Tests\Samples\SampleAttributeTargetClass;
use Tests\Samples\SampleClass;
use Tests\Samples\SampleClassAttribute;
use Tests\TestCase;

use function empaphy\usephul\Type\applies;

#[CoversFunction('empaphy\usephul\Type\applies')]
class AppliesTest extends TestCase
{
    public function testReturnsTrueWhenAttributeIsAppliedToClass(): void
    {
        $condition = applies(SampleAttributeTargetClass::class, SampleClassAttribute::class);
        $this->assertTrue($condition);
    }

    public function testReturnsFalseWhenAttributeIsNotAppliedToClass(): void
    {
        $condition = applies(SampleClass::class, SampleClassAttribute::class);
        $this->assertFalse($condition);
    }

    public function testReturnsTrueWhenAttributeIsAppliedToObject(): void
    {
        $object = new SampleAttributeTargetClass();
        $condition = applies($object, SampleClassAttribute::class);
        $this->assertTrue($condition);
    }

    public function testReturnsFalseWhenAttributeIsNotAppliedToObject(): void
    {
        $object = new SampleClass();
        $condition = applies($object, SampleClassAttribute::class);
        $this->assertFalse($condition);
    }

    public function testReturnsFalseWhenAttributeIsAppliedToParent(): void
    {
        $object = new SampleAttributeTargetChildClass();
        $condition = applies($object, SampleClassAttribute::class);
        $this->assertFalse($condition);
    }

    public function testReturnsFalseWhenReflectionFails(): void
    {
        $condition = applies('ThisClassBetterNotExist', SampleClassAttribute::class); // @phpstan-ignore argument.type
        $this->assertFalse($condition);
    }
}
