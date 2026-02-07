<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_pick;

#[CoversFunction('empaphy\usephul\array_pick')]
class ArrayPickTest extends TestCase
{
    #[TestWith([
        'array'    => ['foo' => 'FOO', 'bar' => 'BAR', 'qux' => null],
        'keys'     => ['bar', 'qux'],
        'expected' => ['bar' => 'BAR', 'qux' => null],
    ])]
    public function testPicksKeysFromAnArray(array $array, array $keys, array $expected): void
    {
        $picked = array_pick($array, ...$keys);
        $this->assertEquals($expected, $picked);
    }
}
