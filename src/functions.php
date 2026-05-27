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

/**
 * Returns the result of the first callback with a parameter type that fits
 * the type of the given value.
 *
 * This function functions similar to a `match` or `switch` statement but
 * uses type checks to gauge which expression to evaluate for __subject__.
 *
 *     use function empaphy\usephul\fit;
 *
 *     $result = fit(
 *         $example,
 *         fn(string $v): string      => "value '$v' is a string",
 *         fn(int|float $v)           => "value is an integer or float",
 *         fn(array $v, object $w)    => "value is an array or an object",
 *         fn(Foo&(Bar|(Baz&Qux)) $v) => "both `Foo` & `Bar` or `Baz` & `Qux`",
 *         fn(mixed $default)         => "value is of some other type",
 *     );
 *
 * If no callback parameters are provided, {@see fit()} will return an instance
 * of the {@see Gauge} class:
 *
 *     $gauge = fit('foo');
 *     $result = $gauge->as(
 *         fn(string $v): string => "value '$v' is a string",
 *     );
 *
 * Which allows for a more readable format:
 *
 *     $result = fit('foo')->as(
 *         fn(string $v): string => "value '$v' is a string",
 *     );
 *
 * {@see fit()} is optimized for performance and makes no recursive calls,
 * or calls to any other helper functions; it's completely self-contained.
 *
 * @package Control\Functions
 *
 * @template TSubject
 * @template TResult
 *
 * @param  TSubject  $subject
 *   The value to gauge.
 *
 * @param  ?Closure(mixed $arg, mixed ...$args): TResult  $callback
 *   A callback function. The first callback argument with a parameter type
 *   that fits __subject__ will be called and its result returned.
 *
 * @param  Closure(mixed $arg, mixed ...$args): TResult  ...$callbacks
 *   Additional callback functions. The first callback function with a parameter
 *   type that fits __subject__ will be called and its result returned.
 *
 * @return ($callback is null ? Gauge<TSubject> : TResult)
 *   The result of the first of the __callbacks__ that fits __subject__.
 *
 * @throws InvalidArgumentException
 *   Thrown if invalid callback arguments are provided.
 *
 * @throws UnhandledFitException
 *   Thrown when no callback function can fit the subject.
 */
function fit(
    mixed    $subject,
    ?Closure $callback = null,
    Closure  ...$callbacks,
): mixed {
    if ($callback === null) {
        if ($callbacks) {
            throw new InvalidArgumentException(
                'Argument #3 (...$callbacks) is not allowed if argument #2'
                . ' ($callback) is null',
            );
        }

        return new Gauge($subject);
    }

    return (new Gauge($subject))->is($callback, ...$callbacks);
}
