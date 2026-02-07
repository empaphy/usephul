<?php

declare(strict_types=1);

namespace Tests\Unit\debug;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function count;
use function debug_backtrace;

use const DEBUG_BACKTRACE_IGNORE_ARGS;

#[CoversNothing]
class DebugBacktraceTest extends TestCase
{
    #[TestWith([-0x7FFFFFFF_FFFFFFFF, 1,])]
    #[TestWith([-0x7FFFFFFF_80000001, null])]
    #[TestWith([-0x7FFFFFFF_80000000, 0,])]
    #[TestWith([-0x00000001_00000001, 0,])]
    #[TestWith([-0x00000001_00000000, null])]
    #[TestWith([-0x00000000_FFFFFFFF, 1,])]
    #[TestWith([-0x00000000_80000001, null])]
    #[TestWith([-0x00000000_80000000, 0,])]
    #[TestWith([-0x00000000_00000001, 0,])]
    #[TestWith([0x00000000_00000000, null])]
    #[TestWith([0x00000000_00000001, 1,])]
    #[TestWith([0x00000000_7FFFFFFF, null])]
    #[TestWith([0x00000000_80000000, 0,])]
    #[TestWith([0x00000000_FFFFFFFF, 0,])]
    #[TestWith([0x00000001_00000000, null])]
    #[TestWith([0x00000001_00000001, 1,])]
    #[TestWith([0x00000001_7FFFFFFF, null])]
    #[TestWith([0x00000001_80000000, 0,])]
    #[TestWith([0x00000001_FFFFFFFF, 0,])]
    #[TestWith([0x00000002_00000000, null])]
    #[TestWith([0x00000002_00000001, 1,])]
    #[TestWith([0x7FFFFFFF_FFFFFFFF, 0,])]
    public function testDebugBacktraceEmpty(int $limit, ?int $expectedCount): void
    {
        $expectedCount ??= count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit);
        $this->assertCount($expectedCount, $backtrace);
    }

    #[TestWith([0x7FFFFFFF_FFFFFFFF])]
    #[TestWith([-0x7FFFFFFF_FFFFFFFF])]
    #[TestWith([-0x7FFFFFFF_80000001])]
    #[TestWith([-0x7FFFFFFF_80000000])]
    #[TestWith([-0x1_00000001])]
    #[TestWith([-0x1_00000000])]
    #[TestWith([-0xFFFFFFFF])]
    #[TestWith([-0x80000001])]
    #[TestWith([-0x80000000])]
    #[TestWith([-0x00000001])]
    #[TestWith([0x00000000])]
    #[TestWith([0x00000001])]
    #[TestWith([0x7FFFFFFF])]
    #[TestWith([0x80000000])]
    #[TestWith([0xFFFFFFFF])]
    #[TestWith([0x1_00000000])]
    #[TestWith([0x1_00000001])]
    #[TestWith([0x1_7FFFFFFF])]
    #[TestWith([0x1_80000000])]
    #[TestWith([0x1_FFFFFFFF])]
    #[TestWith([0x2_00000000])]
    #[TestWith([0x2_00000001])]
    public function testDebugBacktrace2(int $limit): void
    {
        $expected = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit);
        $expectedCount = count($expected);
        $limitMod = $limit & 0xFFFFFFFF;
        $haystack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limitMod);
        $this->assertCount($expectedCount, $haystack);
    }
}
