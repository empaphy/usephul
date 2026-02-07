<?php

declare(strict_types=1);

namespace empaphy\usephul;

use Closure;
use Exception;
use Stringable;

/**
 * An UnhandledFitException is thrown when the subject passed to the fit()
 * function is not a fit for any callback argument.
 */
class UnhandledFitException extends Exception
{
    /**
     * @param  mixed  $subject
     *   Subject that was deemed unfit.
     *
     * @param  array<Closure(mixed $arg, mixed ...$args): mixed>  $callbacks
     *   List of callbacks against which the subject was gauged.
     */
    public function __construct(
        public readonly mixed $subject,
        public readonly array $callbacks,
    ) {
        $value = is_scalar($subject) || $subject instanceof Stringable
            ? $subject
            : print_r($subject, true);
        parent::__construct("Unhandled fit value: $value");
    }
}
