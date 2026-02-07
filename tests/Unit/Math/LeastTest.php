<?php

declare(strict_types=1);

namespace Tests\Unit\Math;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\TestCase;

use function empaphy\usephul\Math\least;

#[CoversFunction('empaphy\usephul\Math\least')]
#[UsesFunction('empaphy\usephul\Math\rank')]
class LeastTest extends TestCase
{
    #[TestWith([1, 2, 1])]
    #[TestWith([2, 1, 1])]
    #[TestWith([1, 1, 1])]
    public function testReturnsTheLeastOfGivenValues(mixed $a, mixed $b, mixed $expected): void
    {
        $least = least($a, $b);
        $this->assertSame($expected, $least);
    }
}
