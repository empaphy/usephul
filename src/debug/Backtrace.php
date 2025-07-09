<?php

declare(strict_types=1);

namespace empaphy\usephul\debug;

use ArrayObject;
use Stringable;
use empaphy\usephul\debug\Backtrace\StackFrame;
use function debug_backtrace;
use const DEBUG_BACKTRACE_IGNORE_ARGS;
use const DEBUG_BACKTRACE_PROVIDE_OBJECT;

/**
 * @extends ArrayObject<int, StackFrame>
 */
class Backtrace extends ArrayObject implements Stringable
{
    public const OPTION_PROVIDE_OBJECT = DEBUG_BACKTRACE_PROVIDE_OBJECT;
    public const OPTION_IGNORE_ARGS    = DEBUG_BACKTRACE_IGNORE_ARGS;

    /**
     * @param  int-mask-of<self::OPTION_*>  $options
     * @param  int                          $limit
     */
    public function __construct(int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0)
    {
        $frames = [];
        foreach (debug_backtrace($options, $limit) as $pos => $frameData) {
            $frames[$pos] = StackFrame::fromFrameElement($frameData);
        }

        parent::__construct($frames);
    }

    public function __toString(): string
    {
        $string = '';
        foreach ($this as $pos => $frame) {
            $string .= "#{$pos} {$frame}";
        }

        return $string;
    }
}
