<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use empaphy\usephul\Var\Type;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_key_types;

#[CoversFunction('empaphy\usephul\array_key_types')]
class ArrayKeyTypesUnit extends TestCase
{
    /**
     * @formatter:off
     */
    #[TestWith([[],                               []])]
    #[TestWith([['FOO', 'BAR'],                   [Type::INTEGER => true]])]
    #[TestWith([[37 => 'FOO', 42 => 'BAR'],       [Type::INTEGER => true]])]
    #[TestWith([['foo' => 'FOO', 'bar' => 'BAR'], [Type::STRING  => true]])]
    #[TestWith([['foo' => 'FOO', 42 => 'BAR'],    [Type::INTEGER => true, Type::STRING => true]])]
    public function testReturnsArrayKeyTypes(array $array, array $expected): void
    {
        $types = array_key_types($array);
        $this->assertSame($expected, $types);
    }
}
