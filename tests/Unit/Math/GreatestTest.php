<?php

declare(strict_types=1);

namespace Tests\Unit\Math;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\TestCase;

use function empaphy\usephul\Math\greatest;

#[CoversFunction('empaphy\usephul\Math\greatest')]
#[UsesFunction('empaphy\usephul\Math\rank')]
class GreatestTest extends TestCase
{
    #[TestWith([1, 2, 2])]
    #[TestWith([2, 1, 2])]
    #[TestWith([1, 1, 1])]
    public function testReturnsTheGreatestValue(mixed $a, mixed $b, mixed $expected): void
    {
        $greatest = greatest($a, $b);
        $this->assertSame($expected, $greatest);
    }
}
