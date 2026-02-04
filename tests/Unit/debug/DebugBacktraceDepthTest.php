<?php

declare(strict_types=1);

namespace Tests\Unit\debug;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function count;
use function debug_backtrace;
use function empaphy\usephul\debug_backtrace_depth;

use const DEBUG_BACKTRACE_IGNORE_ARGS;
use const PHP_INT_MAX;

#[CoversFunction('empaphy\usephul\debug_backtrace_depth')]
class DebugBacktraceDepthTest extends TestCase
{
    public function testReturnsCorrectStackDepthWithDefaultLimit(): void
    {
        $expected = count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
        $actual = debug_backtrace_depth();
        $this->assertSame($expected, $actual);
    }

    #[TestWith([-PHP_INT_MAX])]
    #[TestWith([-0x1_00000001])]
    #[TestWith([-0x1_00000000])]
    #[TestWith([-0xFFFFFFFF])]
    #[TestWith([-0x80000001])]
    #[TestWith([-0x80000000])]
    #[TestWith([-0x7FFFFFFF])]
    #[TestWith([-1])]
    #[TestWith([0])]
    #[TestWith([1])]
    #[TestWith([0x7FFFFFFF])]
    #[TestWith([0x80000000])]
    #[TestWith([0x80000001])]
    #[TestWith([0xFFFFFFFF])]
    #[TestWith([0x1_00000000])]
    #[TestWith([0x1_00000001])]
    #[TestWith([PHP_INT_MAX])]
    public function testReturnsCorrectStackDepth(int $limit): void
    {
        $expected = count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit));
        $depth = debug_backtrace_depth($limit);
        $this->assertSame($expected, $depth);
    }
}
