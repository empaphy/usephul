<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Types
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * A unit enum representing a fallback type.
 *
 * It is inhabited by exactly one case: {@see Fallback::default}.
 *
 * Conceptually, {@see Fallback::default} indicates the lack of an operation
 * having been performed on a variable. This is useful in cases where any
 * value is otherwise valid, and you need to distinguish between "no value
 * provided" and "value explicitly set to `null`".
 *
 * The {@see Fallback::default} case is also aliased as the constant
 * {@see \empaphy\usephul\fallback fallback} for convenience.
 *
 * You can also use the {@see Fallback} enum as a type hint:
 *
 *     function example(string|null|Fallback $param = fallback): void {}
 *
 * And you can use the {@see Fallback::default} case or the
 * {@see \empaphy\usephul\fallback fallback} const as a default value for
 * functions that attempt to retrieve a value without a guarantee, and accept
 * a `$default` argument:
 *
 *     $value = config('some_key', fallback);
 *     if ($value === fallback) {
 *         // 'some_key' was not found
 *     }
 *
 */
enum Fallback
{
    /**
     * The default fallback case.
     */
    case default;
}
