<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Samples\SampleClass;
use Tests\TestCase;

use function empaphy\usephul\Var\is_negative_int;

#[CoversFunction('empaphy\usephul\Var\is_negative_int')]
class IsNegativeIntTest extends TestCase
{
    #[TestWith([-1])]
    public function testReturnsTrue(int $value): void
    {
        $condition = is_negative_int($value);
        $this->assertTrue($condition);
    }

    #[TestWith([0])]
    #[TestWith([1])]
    #[TestWith([-0.1])]
    #[TestWith(['-1'])]
    #[TestWith([[-1]])]
    #[TestWith([new SampleClass()])]
    #[TestWith([null])]
    public function testReturnsFalse(mixed $value): void
    {
        $condition = is_negative_int($value);
        $this->assertFalse($condition);
    }
}
