<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Samples\SampleUnitEnum;
use Tests\TestCase;

use function empaphy\usephul\Var\is_enum_case;

#[CoversFunction('empaphy\usephul\Var\is_enum_case')]
class IsEnumCaseTest extends TestCase
{
    #[TestWith([SampleUnitEnum::Garply])]
    public function testReturnsTrueIfValueIsEnumCase(mixed $value): void
    {
        $condition = is_enum_case($value);
        $this->assertTrue($condition);
    }

    #[TestWith(['Foo'])]
    public function testReturnsFalseIfValueIsNotEnumCase(mixed $value): void
    {
        $condition = is_enum_case($value);
        $this->assertFalse($condition);
    }
}
