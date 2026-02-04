<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use empaphy\usephul\Var\Type;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_key_types;

#[CoversFunction('empaphy\usephul\array_key_types')]
class ArrayKeyTypesTest extends TestCase
{
    #[TestWith([[], []])]
    #[TestWith([['foo', 'bar', 'baz'], [Type::INTEGER => true]])]
    #[TestWith([[0xF00 => 'FOO'], [Type::INTEGER => true]])]
    #[TestWith([['bar' => 'BAR'], [Type::STRING => true]])]
    #[TestWith([[0xF00 => 'FOO', 'bar' => 'BAR'], [Type::INTEGER => true, Type::STRING => true]])]
    #[TestWith([['bar' => 'BAR', 0xF00 => 'FOO'], [Type::INTEGER => true, Type::STRING => true]])]
    public function testReturnsExpectedArrayKeyTypes(array $array, array $expected): void
    {
        $actual = array_key_types($array);
        $this->assertSame($expected, $actual);
    }
}
