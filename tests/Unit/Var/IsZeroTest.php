<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\Var\is_zero;

use const empaphy\usephul\Var\ZERO_TOLERANCE;
use const PHP_FLOAT_EPSILON;
use const PHP_FLOAT_MIN;

#[CoversFunction('empaphy\usephul\Var\is_zero')]
class IsZeroTest extends TestCase
{
    #[TestWith([0, null])]
    #[TestWith([0.0, null])]
    #[TestWith([PHP_FLOAT_MIN, ZERO_TOLERANCE])]
    #[TestWith([PHP_FLOAT_MIN, PHP_FLOAT_MIN])]
    public function testReturnsTrueIfValueIsCloseTo0(int|float $value, ?float $tolerance): void
    {
        $condition = is_zero($value, $tolerance);
        $this->assertTrue($condition);
    }

    #[TestWith([1, ZERO_TOLERANCE])]
    #[TestWith([1.0, ZERO_TOLERANCE])]
    #[TestWith([PHP_FLOAT_EPSILON, PHP_FLOAT_MIN])]
    #[TestWith([PHP_FLOAT_MIN, null])]
    public function testReturnsFalseIfValueIsNotCloseTo0(int|float $value, ?float $tolerance): void
    {
        $isZero = is_zero($value, $tolerance);
        $this->assertFalse($isZero);
    }
}
