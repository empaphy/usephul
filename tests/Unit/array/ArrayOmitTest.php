<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_omit;

#[CoversFunction('empaphy\usephul\array_omit')]
class ArrayOmitTest extends TestCase
{
    #[TestWith([
        'array'    => ['foo' => 'FOO', 'bar' => 'BAR', 'qux' => null],
        'keys'     => ['bar', 'qux'],
        'expected' => ['foo' => 'FOO',],
    ])]
    public function testOmitsKeysFromAnArray(array $array, array $keys, array $expected): void
    {
        $picked = array_omit($array, ...$keys);
        $this->assertEquals($expected, $picked);
    }
}
