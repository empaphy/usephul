<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use empaphy\usephul\Var\Type;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;

#[CoversClass(Type::class)]
class TypeTest extends TestCase
{
    #[DataProviderExternal(TypeData::class, 'valuesProvider')]
    public function testTypeHasTheAppropriateCases(Type $case, string $expected): void
    {
        $this->assertEquals($expected, $case->value);
    }

    #[DataProviderExternal(TypeData::class, 'casesProvider')]
    public function testTypeOfReturnsAppropriateType(mixed $value, Type $expected): void
    {
        $actual = Type::of($value);
        $this->assertSame($expected, $actual);
    }

    #[DataProviderExternal(TypeData::class, 'failCasesProvider')]
    public function testTypeOfDoesNotReturnWrongType(mixed $value, Type $expected): void
    {
        $actual = Type::of($value);
        $this->assertNotSame($expected, $actual);
    }

    #[DataProviderExternal(TypeData::class, 'casesProvider')]
    public function testTypeTryOfReturnsAppropriateType(mixed $value, Type $expected): void
    {
        $actual = Type::tryOf($value);
        $this->assertSame($expected, $actual);
    }

    #[DataProviderExternal(TypeData::class, 'failCasesProvider')]
    public function testTypeTryOfDoesNotReturnWrongType(mixed $value, Type $expected): void
    {
        $actual = Type::tryOf($value);
        $this->assertNotSame($expected, $actual);
    }

    #[DataProviderExternal(TypeData::class, 'casesProvider')]
    public function testTypeIsReturnsTrueWhenTypeMatches(mixed $value, Type $type): void
    {
        $condition = $type->is($value);
        $this->assertTrue($condition);
    }

    #[DataProviderExternal(TypeData::class, 'failCasesProvider')]
    public function testTypeIsReturnsFalse(mixed $value, Type $type): void
    {
        $condition = $type->is($value);
        $this->assertFalse($condition);
    }
}
