<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Samples\SampleClass;
use Tests\TestCase;

use function empaphy\usephul\Var\is_non_empty_string;

#[CoversFunction('empaphy\usephul\Var\is_non_empty_string')]
class IsNonEmptyStringTest extends TestCase
{
    #[TestWith(['foo'])]
    public function testReturnsTrue(string $value): void
    {
        $condition = is_non_empty_string($value);
        $this->assertTrue($condition);
    }

    #[TestWith([1])]
    #[TestWith([0.1])]
    #[TestWith([['foo']])]
    #[TestWith([new SampleClass()])]
    #[TestWith([''])]
    #[TestWith([null])]
    #[TestWith([[]])]
    public function testReturnsFalse(mixed $value): void
    {
        $condition = is_non_empty_string($value);
        $this->assertFalse($condition);
    }
}
