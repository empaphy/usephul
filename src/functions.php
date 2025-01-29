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
