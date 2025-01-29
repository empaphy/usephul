<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\rephine
 */

declare(strict_types=1);

namespace empaphy\rephine;

/**
 * Interchange the values of two elements of an **array**.
 *
 * If a **key** doesn't exist in the **array**, then the other key will be set
 * to `null`, and a warning will be thrown.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @param array<TKey, TValue>  $array
 * @param TKey                 $key1
 * @param TKey                 $key2
 * @return array<TKey, TValue>
 *
 * @noinspection PhpDocSignatureInspection
 */
function array_interchange(array $array, int|string $key1, int|string $key2): array
{
    return [
        ...$array,
        $key1 => $array[$key2],
        $key2 => $array[$key1],
    ];
}

/**
 * Finds whether the given variable is a
 * {@link https://www.php.net/types.resource resource} that has been closed.
 *
 * @template T
 *
 * @param  T  $value  The variable being evaluated.
 * @return (T is resource ? bool : false) Returns `true` if **value** is a
 *                                        <u>resource</u> variable that has been
 *                                        closed, `false` otherwise.
 */
function is_closed_resource(mixed $value): bool
{
    return Type::ClosedResource->is($value);
}
