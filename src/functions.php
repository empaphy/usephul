<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Control
 *
 * @noinspection DuplicatedCode
 * @noinspection SuspiciousBinaryOperationInspection
 */

declare(strict_types=1);

namespace empaphy\usephul;

use Closure;
use InvalidArgumentException;
use ReflectionException;
use ReflectionFunction;
use ReflectionIntersectionType;
use ReflectionType;
use ReflectionUnionType;

use function assert;
use function count;
use function get_debug_type;
use function is_string;
use function sprintf;

/**
 * Returns the result of the first callback with a parameter type that fits
 * the type of the given value.
 *
 * This function functions similar to a `match` or `switch` statement but uses
 * type checks to gauge which expression to evaluate for __subject__.
 *
 *     use empaphy\usephul\Fallback;
 *     use function empaphy\usephul\fit;
 *
 *     $result = fit(
 *         $example,
 *         fn(string $v): string      => "value '$v' is a string",
 *         fn(int|float $v)           => "value is an integer or float",
 *         fn(array $v, object $w)    => "value is an array or an object",
 *         fn(Foo&(Bar|(Baz&Qux)) $v) => "both `Foo` & `Bar` or `Baz` & `Qux`",
 *         fn(Fallback $default)      => "value is of some other type",
 *     );
 *
 * This function supports {@see \empaphy\usephul\Fallback} as callback argument
 * type to indicate a default case. Alternatively, you can use `mixed`.
 *
 * {@see fit()} is optimized for performance and makes no recursive calls, or
 * calls to any other helper functions; it's completely self-contained.
 *
 * @package Control\Functions
 *
 * @template TFit
 * @template TResult
 * @template TSubject of TFit
 *
 * @param  TSubject  $subject
 *   The value to gauge.
 *
 * @param  Closure(TFit $arg, TFit ...$args): TResult  $callback
 *   A callback function. The first callback argument with a parameter type
 *   that fits __subject__ will be called and its result returned.
 *
 * @param  Closure(TFit $arg, TFit ...$args): TResult  ...$callbacks
 *   Additional callback functions. The first callback function with a parameter
 *   type that fits __subject__ will be called and its result returned.
 *
 * @return TResult
 *   The result of the first of the __callbacks__ that fits __subject__.
 *
 * @throws (TFit is empty ? InvalidArgumentException : never)
 *   Thrown if a callback has no parameters, or if any callback parameter is
 *   missing a type declaration.
 *
 * @throws ($subject is TFit ? never : UnhandledFitException)
 *   Thrown when no callback function can fit the subject.
 */
function fit(mixed $subject, Closure $callback, Closure ...$callbacks): mixed
{
    $subjectType = get_debug_type($subject);

    $argumentPosition = 2;
    foreach ([$callback, ...$callbacks] as $key => $fn) {
        try {
            $reflectionFunction = new ReflectionFunction($fn);
        } catch (ReflectionException) {  // @codeCoverageIgnore
            continue;                    // @codeCoverageIgnore
        }

        if ($reflectionFunction->getNumberOfParameters() === 0) {
            throw new InvalidArgumentException(
                sprintf(
                    'Argument #%d (...$callbacks[%s])'
                    . ' must have at least one parameter',
                    $argumentPosition,
                    is_string($key) ? "'$key'" : $key,
                ),
            );
        }

        $types = [[]];
        foreach ($reflectionFunction->getParameters() as $parameter) {
            $types[0][] = $parameter->getType();
        }

        // Please forgive me for the hard-to-read code that follows. To avoid
        // using recursion or helper functions, I implemented a custom
        // stack-based algorithm to traverse the type graph of the callback
        // parameters.

        $modes = [true];
        $inits = [false];
        $nums = [count($types[0])];
        $pos = [0];
        $fit = false;

        for ($l = 0; $l > -1;) {
            $type = $types[$l][$pos[$l]++];
            $mode = $type instanceof ReflectionUnionType;
            $init = $type instanceof ReflectionIntersectionType;

            if ($mode || $init) {
                $l++;
                $types[$l] = $type->getTypes();
                $inits[$l] = $init;
                $modes[$l] = $mode;
                $nums[$l] = count($types[$l]);
                $pos[$l] = 0;

                continue;
            }

            if ($type === null) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Argument #%d (...$callbacks[%s])'
                        . ' must have a type declaration',
                        $argumentPosition,
                        is_string($key) ? "'$key'" : $key,
                    ),
                );
            }

            assert($type instanceof ReflectionType);

            $typeName = (string) $type;
            $fit = $subjectType === $typeName
                || $subject instanceof $typeName
                || 'mixed' === $typeName;

            while ($l > -1 && ($fit === $modes[$l] || $pos[$l] === $nums[$l])) {
                if ($pos[$l] === $nums[$l] && $fit !== $modes[$l]) {
                    $fit = $inits[$l];
                }

                unset($types[$l], $modes[$l], $nums[$l], $pos[$l], $inits[$l]);
                $l--;
            }
        }

        if ($fit) {
            return $fn($subject);
        }

        $argumentPosition++;
    }

    throw new UnhandledFitException($subject, [$callback, ...$callbacks]);
}
