<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use empaphy\usephul\Var\Type;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\TestCase;

use function empaphy\usephul\Var\is_closed_resource;

#[CoversFunction('empaphy\usephul\Var\is_closed_resource')]
#[UsesClass(Type::class)]
class IsClosedResourceTest extends TestCase
{
    #[DataProviderExternal(TypeData::class, 'casesProvider')]
    public function testCorrectlyReturnsWhetherValueIsAClosedResource(mixed $value, Type $type): void
    {
        $actual = is_closed_resource($value);
        $expected = Type::ClosedResource === $type;
        $this->assertSame($expected, $actual);
    }
}
