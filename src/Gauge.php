<?php

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
 * Used to gauge whether given subject fits a list of callbacks.
 *
 * @template-covariant TSubject
 */
final class Gauge
{
    /**
     * @param  TSubject  $subject
     *   The value to gauge.
     */
    public function __construct(public readonly mixed $subject) {}

    /**
     * @template TResult
     *
     * @param  Closure(mixed $arg, mixed ...$args): TResult  $callback
     *   A callback function. The first callback argument with a parameter
     *   type that fits __subject__ will be called and its result returned.
     *
     * @param  Closure(mixed $arg, mixed ...$args): TResult  ...$callbacks
     *   Callback functions. The first callback function with a parameter
     *   type that fits __subject__ will be called and its result returned.
     *
     * @return TResult
     *   The result of the first of the __callbacks__ that fits __subject__.
     *
     * @throws UnhandledFitException
     *   Thrown when no callback function can fit the subject.
     */
    public function is(Closure $callback, Closure ...$callbacks): mixed
    {
        $subjectType = get_debug_type($this->subject);

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
                    || $this->subject instanceof $typeName
                    || true === $this->subject && 'true' === $typeName
                    || false === $this->subject && 'false' === $typeName
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
                return $fn($this->subject);
            }

            $argumentPosition++;
        }

        throw new UnhandledFitException($this->subject, [$callback, ...$callbacks]);
    }
}
