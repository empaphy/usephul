<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_interchange;

#[CoversFunction('empaphy\usephul\array_interchange')]
class ArrayInterchangeTest extends TestCase
{
    #[TestWith([
        'array'    => [3, 5, 7, 11, 13],
        'key1'     => 1,
        'key2'     => 3,
        'expected' => [3, 11, 7, 5, 13],
    ])]
    #[TestWith([
        'array'    => ['foo' => 0xF00, 'bar' => 0x8A9, 'bat' => 0x8A7, 'baz' => 0x8A2, 'fuz' => 0xF42],
        'key1'     => 'bar',
        'key2'     => 'baz',
        'expected' => ['foo' => 0xF00, 'bar' => 0x8A2, 'bat' => 0x8A7, 'baz' => 0x8A9, 'fuz' => 0xF42],
    ])]
    public function testInterchangesElements(array $array, int|string $key1, int|string $key2, array $expected): void
    {
        $actual = array_interchange($array, $key1, $key2);
        $this->assertSame($expected, $actual);
    }

    public function testReplacesElementsWithNullIfTheReplacementKeyDoesNotExist(): void
    {
        $this->expectWarning('Undefined array key 3');
        $actual = array_interchange([3, 5, 7], 1, 3);
        $this->assertNull($actual[1]);
    }
}
