<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\array_zip;

#[CoversFunction('empaphy\usephul\array_zip')]
class ArrayZipTest extends TestCase
{
    /**
     * @formatter:off
     */
    #[TestWith([
        'arrays'   => [['foo', 'bar']],
        'expected' => [['foo'], ['bar']],
    ])]
    #[TestWith([
        'arrays'   => [
            ['foo',    'bar'],
            ['jantje', 'pietje', 'hansje', 'henkje'],
            ['spam',   'ham',    'eggs'],
        ],
        'expected' => [
            ['foo', 'jantje', 'spam'],
            ['bar', 'pietje', 'ham' ],
            [ null, 'hansje', 'eggs'],
            [ null, 'henkje',  null ],
        ],
    ])]
    #[TestWith([
        'arrays'   => [
            ['FOO'  => 'foo',    'BAR'  => 'bar'],
            ['JAN'  => 'jantje', 'PIET' => 'pietje', 'HANS' => 'hansje', 'HENK' => 'henkje'],
            ['SPAM' => 'spam',   'HAM'  => 'ham',    'EGGS' => 'eggs'],
        ],
        'expected' => [
            ['foo', 'jantje', 'spam'],
            ['bar', 'pietje', 'ham' ],
            [ null, 'hansje', 'eggs'],
            [ null, 'henkje',  null ],
        ],
    ])]
    public function testZipsArrays(array $arrays, array $expected): void
    {
        $zippedArray = array_zip(...$arrays);
        $this->assertSame($expected, $zippedArray);
    }
}
