<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_exclude;

#[CoversFunction('empaphy\usephul\array_exclude')]
class ArrayExcludeTest extends TestCase
{
    #[TestWith([
        'array'    => ['foo' => 'FOO', 'bar' => 'BAR', 'qux' => null],
        'values'   => ['BAR', null],
        'expected' => ['foo' => 'FOO'],
    ])]
    #[TestWith([
        'array'    => ['FOO', 'BAR', null],
        'values'   => ['BAR', null],
        'expected' => ['FOO'],
    ])]
    public function testExcludesValuesFromArray(array $array, array $values, array $expected): void
    {
        $actual = array_exclude($array, ...$values);
        $this->assertSame($expected, $actual);
    }
}
