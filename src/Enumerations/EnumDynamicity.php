<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Enumerations
 */

declare(strict_types=1);

namespace empaphy\rephine\Enumerations;

/**
 * Adds dynamicity of case names to PHP Enumerations.
 *
 * It provides a method to dynamically retrieve an Enumeration case by its name.
 */
trait EnumDynamicity
{
    /**
     * Maps a string to an enum instance or NULL.
     *
     * The **try()** method translates a <u>string</u> or <u>int</u> into the
     * corresponding Enum case, if any. If there is no matching case defined, it
     * will return `NULL`.
     *
     * @param  non-empty-string  $name  The name to map to an enum case.
     * @return self|null A case instance of this enum, or `null` if not found.
     *
     * @throws \ValueError if an empty string is provided as **name**.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public static function try(string $name): ?self
    {
        if ('' === $name) {
            throw new \ValueError(
                'An empty string ("") is not a valid name for an enum case.'
            );
        }

        return \array_find(
            self::cases(),
            static fn(\UnitEnum $case): bool => $case->name === $name
        );
    }
}
