<?php

declare(strict_types=1);

namespace empaphy\usephul\Enumerations;

use UnitEnum;

interface DynamicEnum extends UnitEnum
{
    /**
     * Maps a string to an enum instance or NULL.
     *
     * The {@see try()} method translates a `string` or `int` into the
     * corresponding Enum case, if any. If there is no matching case defined,
     * it will return `NULL`.
     *
     * @param  non-empty-string  $name
     *   The name to map to an enum case.
     *
     * @return self|null
     *   A case instance of this enum, or `null` if not found.
     *
     * @throws \ValueError if an empty string is provided as __name__.
     */
    public static function try(string $name): ?self;
}
