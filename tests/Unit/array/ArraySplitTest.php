<?php

declare(strict_types=1);

namespace Tests\Unit\array;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Samples\SampleClass;
use Tests\TestCase;

use function empaphy\usephul\array_split;

use const PHP_INT_MAX;

#[CoversFunction('empaphy\usephul\array_split')]
class ArraySplitTest extends TestCase
{
    public static function arraySplitProvider(): array
    {
        $o = new SampleClass();

        return [ //@formatter:off
            'separator: object, limit: max, strict: true' => [
                $o, PHP_INT_MAX, true,
                [ 'a' => 'A' , 'b' => $o , 2 => 2 , 3 => $o ,'4' => '4' , 5 => $o , 6 => 'G' , 7 => $o , 8 => 'I' ],
                [['a' => 'A'],            [2 => 2],         ['4' => '4'],          [6 => 'G'],          [8 => 'I']],
            ],
            'separator: new SampleClass, limit: max, strict: false' => [
                new SampleClass(), PHP_INT_MAX, false,
                [ 'a' => 'A' , 'b' => $o , 2 => 2 , 3 => $o ,'4' => '4' , 5 => $o , 6 => 'G' , 7 => $o , 8 => 'I' ],
                [['a' => 'A'],            [2 => 2],         ['4' => '4'],          [6 => 'G'],          [8 => 'I']],
            ],
            'separator: new SampleClass, limit: max, strict: true' => [
                new SampleClass(), PHP_INT_MAX, true,
                [ 'a' => 'A' , 'b' => $o , 2 => 2 , 3 => $o ,'4' => '4' , 5 => $o , 6 => 'G' , 7 => $o , 8 => 'I' ],
                [['a' => 'A' , 'b' => $o , 2 => 2 , 3 => $o ,'4' => '4' , 5 => $o , 6 => 'G' , 7 => $o , 8 => 'I']],
            ],
            'separator: [], limit: 10, strict: true' => [
                [], 10, true,
                [ 0 => '_' , 1 => [] , 2 => '_' , 3 =>true, 4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>true, 4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:  [], limit: 9, strict: false' => [
                [], 9, false,
                [ 0 => '_' , 1 => [] , 2 => '_' , 3 =>true, 4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>true, 4 => '_'],          [6 => '_'],          [8 => '_']],
            ],
            'separator: [1], limit: 8, strict: true' => [
                [1], 8, true,
                [ 0 => '_' , 1 => [1], 2 => '_' , 3 =>true, 4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>true, 4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator: [1], limit: 7, strict: false' => [
                [1], 7, false,
                [ 0 => '_' , 1 => [1], 2 => '_' , 3 =>true, 4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_' , 5 =>false,6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator: "1", limit: 3, strict: true' => [
                '1', 3, true,
                [ 0 => '_' , 1 => '1', 2 => '_' , 3 =>true, 4 => '_' , 5 =>  1 , 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>true, 4 => '_' , 5 =>  1 , 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator: "1", limit: 5, strict: false' => [
                '1', 5, false,
                [ 0 => '_' , 1 => '1', 2 => '_' , 3 =>true, 4 => '_' , 5 =>  1 , 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator: "0", limit: 6, strict: true' => [
                '0', 6, true,
                [ 0 => '_' , 1 => '0', 2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator: "0", limit: 5, strict: false' => [
                '0', 5, false,
                [ 0 => '_' , 1 => '0', 2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:  1 , limit: 5, strict: true' => [
                1, 5, true,
                [ 0 => '_' , 1 =>  1 , 2 => '_' , 3 =>true, 4 => '_' , 5 => "1", 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>true, 4 => '_' , 5 => "1", 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:  1 , limit: 5, strict: false' => [
                1, 5, false,
                [ 0 => '_' , 1 =>  1 , 2 => '_' , 3 =>true, 4 => '_' , 5 => "1", 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:  0 , limit: 5, strict: true' => [
                0, 5, true,
                [ 0 => '_' , 1 =>  0 , 2 => '_' , 3 =>false,4 => '_' , 5 => '0', 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>false,4 => '_' , 5 => '0', 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:  0 , limit: 5, strict: false' => [
                0, 5, false,
                [ 0 => '_' , 1 =>  0 , 2 => '_' , 3 =>false,4 => '_' , 5 => '0', 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_'],          [8 => '_']],
            ],
            'separator:true, limit: 5, strict: true' => [
                true, 5, true,
                [ 0 => '_' , 1 =>true, 2 => '_' , 3 =>  1 , 4 => '_' , 5 => '1', 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>  1 , 4 => '_' , 5 => '1', 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:true, limit: 5, strict: false' => [
                true, 5, false,
                [ 0 => '0' , 1 =>true, 2 => '0' , 3 =>  1 , 4 => '0' , 5 => '1', 6 => '0' , 7 =>null, 8 => '0' ],
                [[0 => '0'],          [2 => '0'],          [4 => '0'],          [6 => '0' , 7 =>null, 8 => '0']],
            ],
            'separator:false,limit: 5, strict: true' => [
                false, 5, true,
                [ 0 => '_' , 1 =>false,2 => '_' , 3 =>  0 , 4 => '_' , 5 => '0', 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>  0 , 4 => '_' , 5 => '0', 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator:false,limit: 5, strict: false' => [
                false, 5, false,
                [ 0 => '_' , 1 =>false,2 => '_' , 3 =>  0 , 4 => '_' , 5 => '0', 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_'],          [8 => '_']],
            ],
            'separator:null, limit: 5, strict: true' => [
                null, 5, true,
                [ 0 => '_' , 1 =>null, 2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 => [] , 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 => [] , 8 => '_']],
            ],
            'separator:null, limit: 5, strict: false' => [
                null, 5, false,
                [ 0 => '_' , 1 =>null, 2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 => [] , 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_'],          [8 => '_']],
            ],
            'separator: "" , limit: 5, strict: true' => [
                '', 5, true,
                [ 0 => '_' , 1 => '' , 2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 =>null, 8 => '_']],
            ],
            'separator: "" , limit: 5, strict: false' => [
                '', 5, false,
                [ 0 => '_' , 1 => '' , 2 => '_' , 3 =>false,4 => '_' , 5 =>  0 , 6 => '_' , 7 =>null, 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_' , 5 =>  0 , 6 => '_'],          [8 => '_']],
            ],
            'separator: "x", limit: 5, strict: false' => [
                'x', 5, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_'],          [8 => '_']],
            ],
            'separator: "x", limit: 4, strict: false' => [
                'x', 4, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_' , 7 => 'x', 8 => '_']],
            ],
            'separator: "x", limit: 3, strict: false' => [
                'x', 3, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_']],
            ],
            'separator: "x", limit: 2, strict: false' => [
                'x', 2, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_']],
            ],
            'separator: "x", limit: 1, strict: false' => [
                'x', 1, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_']],
            ],
            'separator: "x", limit: 0, strict: false' => [
                'x', 0, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_']],
            ],
            'separator: "x", limit:-1, strict: false' => [
                'x', -1, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_'],          [6 => '_']],
            ],
            'separator: "x", limit:-2, strict: false' => [
                'x', -2, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_'],          [4 => '_']],
            ],
            'separator: "x", limit:-3, strict: false' => [
                'x', -3, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_'],          [2 => '_']],
            ],
            'separator: "x", limit:-4, strict: false' => [
                'x', -4, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [[0 => '_']],
            ],
            'separator: "x", limit:-5, strict: false' => [
                'x', -5, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [],
            ],
            'separator: "x", limit:-6, strict: false' => [
                'x', -6, true,
                [ 0 => '_' , 1 => 'x', 2 => '_' , 3 => 'x', 4 => '_' , 5 => 'x', 6 => '_' , 7 => 'x', 8 => '_' ],
                [],
            ],
        ]; //@formatter:on
    }

    #[DataProvider('arraySplitProvider')]
    public function testSplitsAnArrayBySeparatorValue(
        mixed $separator,
        int   $limit,
        bool  $strict,
        array $array,
        array $expected,
    ): void {
        $actual = array_split($array, $separator, $limit, $strict);
        $this->assertEquals($expected, $actual);
    }
}
