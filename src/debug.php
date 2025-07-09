<?php

declare(strict_types=1);

namespace empaphy\usephul;

use empaphy\usephul\debug\Backtrace\StackFrame;

use const PHP_EOL;

/**
 * @template T
 *
 * @param  int-mask-of<Backtrace::OPTION_*>  $options
 * @param  T                                 $return
 * @param  T                                 $returnValue
 * @return T
 */
function &debug_print_frame(
    mixed &$return = null,
    mixed $returnValue = null,
    int   $options = debug\Backtrace::OPTION_PROVIDE_OBJECT,
): mixed {
    $stackFrame = StackFrame::current($options, 1);
    if (null !== $return) {
        echo $stackFrame . ': ' . json_encode($return) . PHP_EOL;
        return $return;
    }

    if (null !== $returnValue) {
        echo $stackFrame . ': ' . json_encode($returnValue) . PHP_EOL;
        return $returnValue;
    }

    echo $stackFrame . PHP_EOL;

    return $return;
}

/**
 * @param  int-mask-of<Backtrace::OPTION_*>  $options
 * @return StackFrame
 */
function debug_frame(
    int $options = debug\Backtrace::OPTION_PROVIDE_OBJECT,
): StackFrame {
    return StackFrame::current($options);
}
