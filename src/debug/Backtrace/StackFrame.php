<?php

declare(strict_types=1);

namespace empaphy\usephul\debug\Backtrace;

use Stringable;
use function debug_backtrace;
use function getcwd;
use const DEBUG_BACKTRACE_PROVIDE_OBJECT;

/**
 * @template TObject
 *
 * @implements Frame<TObject>
 */
class StackFrame implements Frame, Stringable
{
    /**
     * @param  string                      $file
     * @param  int                         $line
     * @param  string                      $function
     * @param  null|class-string<TObject>  $class
     * @param  null|object                 $object
     * @param  null|MethodCallType         $type
     * @param  null|array<                 $args
     */
    private function __construct(
        public readonly string          $file,
        public readonly int             $line,
        public readonly string          $function,
        public readonly ?string         $class = null,
        public readonly ?object         $object = null,
        public readonly ?MethodCallType $type =  null,
        public readonly ?array          $args = null,
    ) {}

    /**
     * @param  int-mask-of<self::OPTION_*>  $options
     * @param
     * @return self
     */
    public static function current(int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $depth = 0): self
    {
        $backtrace = debug_backtrace($options, ++$depth + 1);
        return self::fromFrameElement($backtrace[$depth]);
    }

    /**
     * @template T
     *
     * @param  array{
     *             file:     string,
     *             line:     int,
     *             function: string,
     *             class?:   class-string<T>,
     *             object?:  T,
     *             type?:    value-of<MethodCallType>,
     *             args?:    array,
     *         }  $data
     * @return self
     */
    public static function fromFrameElement(array $data): self
    {
        return new self(
            file:     $data['file'],
            line:     $data['line'],
            function: $data['function'],
            class:    $data['class'] ?? null,
            object:   $data['object'] ?? null,
            type:     MethodCallType::tryFrom($data['type'] ?? ''),
            args:     $data['args'] ?? null,
        );
    }

    public function __toString(): string
    {
        $file  = self::getRelativePath(getcwd(), $this->file);
        $line  = $this->line;
        $func  = $this->function;
        $class = $this->class ?? '';
        $type  = $this->type?->value ?? '';
        $args  = implode(', ', array_map(
            static fn ($v) => json_encode($v), $this->args ?? []
        ));

        return "{$file}({$line}): {$class}{$type}{$func}({$args})";
    }

    private static function getRelativePath(string $here, string $there): string
    {
        // some compatibility fixes for Windows paths
        $here = is_dir($here) ? rtrim($here, '\/') . '/' : $here;
        $there = is_dir($there)   ? rtrim($there, '\/') . '/'   : $there;
        $here = str_replace('\\', '/', $here);
        $there = str_replace('\\', '/', $there);

        $here     = explode('/', $here);
        $there    = explode('/', $there);
        $relPath  = $there;

        foreach($here as $depth => $dir) {
            // find first non-matching dir
            if($dir === $there[$depth]) {
                // ignore this directory
                array_shift($relPath);
            } else {
                // get number of remaining dirs to $from
                $remaining = count($here) - $depth;
                if($remaining > 1) {
                    // add traversals up to first matching dir
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath = array_pad($relPath, $padLength, '..');
                    break;
                } else {
                    $relPath[0] = './' . $relPath[0];
                }
            }
        }
        return implode('/', $relPath);
    }
}
