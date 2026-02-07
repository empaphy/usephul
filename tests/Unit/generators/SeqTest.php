<?php

declare(strict_types=1);

namespace Tests\Unit\generators;

use empaphy\usephul\Var\Type;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use RangeException;
use Tests\TestCase;

use function empaphy\usephul\generators\seq;

#[CoversFunction('empaphy\usephul\generators\seq')]
#[UsesClass(Type::class)]
class SeqTest extends TestCase
{
    public static function properSeqValuesProvider(): array
    {
        return [
            'true  => [true]'                      => [true, [true]],
            'false => [false]'                     => [false, [false]],
            'null  => [null]'                      => [null, [null]],
            '1     => [1]'                         => [1, [1]],
            '"1"   => [1]'                         => ['1', ['1']],
            '"abc" => ["a", "b", "c"]'             => ['abc', ['a', 'b', 'c']],
            '[1, 2, 3] => [1, 2, 3]'               => [[1, 2, 3], [0 => 1, 1 => 2, 2 => 3]],
            '{a: 1, b: 2} => ["a" => 1, "b" => 2]' => [(object) ['a' => 1, 'b' => 2], ['a' => 1, 'b' => 2]],
        ];
    }

    #[DataProvider('properSeqValuesProvider')]
    public function testProperlySequencesValues(mixed $data, mixed $expected): void
    {
        $actual = [];

        foreach (seq($data) as $key => $value) {
            $actual[$key] = $value;
        }

        $this->assertSame($expected, $actual);
    }

    public function testThrowsRangeExceptionWithFloat(): void
    {
        $this->expectException(RangeException::class);
        foreach (seq(1.2) as $value) {
            $this->fail("Should not iterate over resource and give value `$value`.");
        }
    }

    public function testThrowsRangeExceptionWithResource(): void
    {
        $this->expectException(RangeException::class);
        $resource = fopen('php://memory', 'rb+');
        foreach (seq($resource) as $value) {
            $this->fail("Should not iterate over resource and give value `$value`.");
        }
    }
}
