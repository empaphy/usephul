<?php

declare(strict_types=1);

namespace Tests\Unit\Enumerations;

use empaphy\usephul\Enumerations\EnumDynamicity;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;
use Tests\Unit\Enumerations\EnumDynamicity\SampleDynamicEnum;
use ValueError;

#[CoversTrait(EnumDynamicity::class)]
#[RequiresPhpunit('>=11.2')]
class EnumDynamicityCoversTraitTest extends TestCase
{
    #[TestWith(['mock' => SampleDynamicEnum::Foo])]
    #[TestWith(['mock' => SampleDynamicEnum::Bar])]
    public function testTryReturnsEnumCaseForProvidedName(SampleDynamicEnum $mock): void
    {
        $case = SampleDynamicEnum::try($mock->name);
        $this->assertSame($mock, $case);
    }

    public function testTryReturnsNullIfAProvidedNameDoesNotExist(): void
    {
        $case = SampleDynamicEnum::try('Baz');
        $this->assertNull($case);
    }

    public function testThrowsAValueErrorWhenProvidedAnEmptyString(): void
    {
        $this->expectException(ValueError::class);
        SampleDynamicEnum::try(''); // @phpstan-ignore argument.type
    }
}
