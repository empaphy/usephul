<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_extract;

#[CoversFunction('empaphy\usephul\array_extract')]
class ArrayExtractTest extends TestCase
{
    #[TestWith([
        'array'    => ['foo' => 'FOO', 'bar' => 'BAR', 'qux' => null],
        'values'   => ['FOO'],
        'expected' => ['foo' => 'FOO'],
    ])]
    public function testExtractsValuesFromArray(array $array, array $values, array $expected): void
    {
        $actual = array_extract($array, ...$values);
        $this->assertSame($expected, $actual);
    }
}
