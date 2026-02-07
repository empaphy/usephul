<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Samples\SampleClass;
use Tests\TestCase;

use function empaphy\usephul\Var\is_number;

use const NAN;

#[CoversFunction('empaphy\usephul\Var\is_number')]
class IsNumberTest extends TestCase
{
    #[TestWith([1])]
    #[TestWith([0])]
    #[TestWith([-1])]
    #[TestWith([0.1])]
    #[TestWith([NAN])]
    public function testReturnsTrue(mixed $value): void
    {
        $condition = is_number($value);
        $this->assertTrue($condition);
    }

    #[TestWith(['1'])]
    #[TestWith(['0'])]
    #[TestWith(['-1'])]
    #[TestWith([new SampleClass()])]
    #[TestWith([null])]
    #[TestWith([[]])]
    public function testReturnsFalse(mixed $value): void
    {
        $condition = is_number($value);
        $this->assertFalse($condition);
    }
}
