<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection MultipleExpectChainableInspection
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\debug;

use function count;
use function debug_backtrace;
use function empaphy\usephul\debug_backtrace_depth;

use const DEBUG_BACKTRACE_IGNORE_ARGS;
use const PHP_INT_MAX;

describe('Error Handling Functions', function () {
    describe('debug_backtrace_depth()', function () {
        test('returns correct stack depth with default __limit__', function () {
            $expected = count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
            $depth = debug_backtrace_depth();
            expect($depth)->toBe($expected);
        });

        test('returns correct stack depth', function ($limit) {
            $expected = count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit));
            $depth = debug_backtrace_depth($limit);
            expect($depth)->toBe($expected);
        })->with([
            ' -PHP_INT_MAX' => ['limit' =>  -PHP_INT_MAX],
            '-0x1_00000001' => ['limit' => -0x1_00000001],
            '-0x1_00000000' => ['limit' => -0x1_00000000],
            '  -0xFFFFFFFF' => ['limit' =>   -0xFFFFFFFF],
            '  -0x80000001' => ['limit' =>   -0x80000001],
            '  -0x80000000' => ['limit' =>   -0x80000000],
            '  -0x7FFFFFFF' => ['limit' =>   -0x7FFFFFFF],
            '           -1' => ['limit' =>            -1],
            '            0' => ['limit' =>             0],
            '            1' => ['limit' =>             1],
            '   0x7FFFFFFF' => ['limit' =>    0x7FFFFFFF],
            '   0x80000000' => ['limit' =>    0x80000000],
            '   0x80000001' => ['limit' =>    0x80000001],
            '   0xFFFFFFFF' => ['limit' =>    0xFFFFFFFF],
            ' 0x1_00000000' => ['limit' =>  0x1_00000000],
            ' 0x1_00000001' => ['limit' =>  0x1_00000001],
            '  PHP_INT_MAX' => ['limit' =>   PHP_INT_MAX],
        ]);
    });
});
