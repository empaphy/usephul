<?php

declare(strict_types=1);

namespace empaphy\usephul;

use UnitEnum;

/**
 * Checks if all enum cases satisfy a callback function.
 *
 * {@see enum_all()} returns `true` if the given __callback__ returns `true`
 * for all cases. Otherwise, the function returns `false`.
 *
 * @template TEnum of UnitEnum
 *
 * @param  class-string<TEnum>  $enum
 *   The enum that should be searched.
 *
 * @param  callable(TEnum $case): bool  $callback
 *   The callback function to call to check each case. If this function returns
 *   `false`, `false` is returned from {@see enum_all()} and the callback will
 *   not be called for further cases.
 *
 * @return bool
 *   The function returns `true` if __callback__ returns `true` for all cases.
 *   Otherwise, the function returns `false`.
 */
function enum_all(string $enum, callable $callback): bool
{
    foreach ($enum::cases() as $case) {
        if (! $callback($case)) {
            return false;
        }
    }

    return true;
}

/**
 * Checks if at least one enum case satisfy a callback function.
 *
 * {@see enum_any()} returns `true` if the given __callback__ returns `true`
 * for any case. Otherwise, the function returns `false`.
 *
 * @template TEnum of UnitEnum
 *
 * @param  class-string<TEnum>  $enum
 *   The enum that should be searched.
 *
 * @param  callable(TEnum $case): bool  $callback
 *   The callback function to call to check each case. If this function returns
 *   `true`, `true` is returned from {@see enum_any()} and the callback will
 *   not be called for further cases.
 *
 * @return bool
 *   The function returns `true` if there is at least one case for which
 *   __callback__ returns `true`. Otherwise, the function returns `false`.
 */
function enum_any(string $enum, callable $callback): bool
{
    foreach ($enum::cases() as $case) {
        if ($callback($case)) {
            return true;
        }
    }

    return false;
}

/**
 * Counts the number of cases in an enum.
 *
 * @param  class-string<UnitEnum>  $enum
 *   The enum for which to count the cases.
 *
 * @return int
 *   Returns the number of cases in __enum__.
 */
function enum_count(string $enum): int
{
    return count($enum::cases());
}

/**
 * @template TEnum of UnitEnum
 *
 * @param  class-string<TEnum>  $enum
 * @return TEnum
 *
 * @noinspection PhpDocSignatureInspection
 */
function enum_first(string $enum): UnitEnum
{
    return $enum::cases()[0];
}
