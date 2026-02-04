<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_get;

#[CoversFunction('empaphy\usephul\array_get')]
class ArrayGetTest extends TestCase
{
    #[TestWith(['array' => [], 'keys' => [], 'expected' => []])]
    #[TestWith(['array' => ['foo.bar' => ['baz' => 'qux']], 'keys' => ['foo.bar', 'baz'], 'expected' => 'qux'])]
    #[TestWith(['array' => ['foo' => ['qux', ['bar' => 'baz']]], 'keys' => ['foo', 1, 'bar'], 'expected' => 'baz'])]
    public function testGetsValueFromArray(array $array, array $keys, mixed $expected): void
    {
        $actual = array_get($array, ...$keys);
        $this->assertSame($expected, $actual);
    }

    #[TestWith(['array' => [], 'keys' => ['foo'], 'message' => 'Undefined array key "foo"'])]
    public function testGetsNoValueWhenKeyDoesNotExist(array $array, array $keys, mixed $message): void
    {
        $this->expectWarning($message);
        $actual = array_get($array, ...$keys);
        $this->assertNull($actual);
    }
}
