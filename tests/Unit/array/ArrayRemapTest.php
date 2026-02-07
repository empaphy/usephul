<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function array_flip;
use function empaphy\usephul\array_remap;

#[CoversFunction('empaphy\usephul\array_remap')]
class ArrayRemapTest extends TestCase
{
    #[TestWith(['map' => ['foo' => 'FOO', 'bar' => 'BAR']])]
    public function testYieldsFromGenerators(array $map): void
    {
        $remap = array_remap(
            fn($key, $value) => yield $value => $key,
            $map,
        );
        $this->assertEquals(array_flip($map), $remap);
    }

    #[TestWith([
        'map'      => ['foo' => 'FOO', 'bar' => 'BAR'],
        'expected' => ['foo' => 'foo', 'bar' => 'bar'],
    ])]
    public function testYieldsFromCallable(array $map, array $expected): void
    {
        $remap = array_remap(fn($key, $value) => $key, $map);
        $this->assertEquals($expected, $remap);
    }
}
