<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Types
 */

declare(strict_types=1);

namespace empaphy\usephul\type;

use empaphy\usephul\var\Type;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;

use function empaphy\usephul\class_parents_traits_uses;
use function empaphy\usephul\class_traits_uses;
use function is_string;

/**
 * Finds whether an attribute has been applied to a given object, class,
 * interface, or trait.
 *
 * @package Types\Attributes
 *
 * @param  object|class-string  $object_or_class
 *   A class name or an object instance.
 *
 * @param  class-string  $attribute
 *   The attribute name.
 *
 * @return bool
 *   `true` if the attribute has been applied to the given object or class.
 *   `false` otherwise.
 */
function applies(object | string $object_or_class, string $attribute): bool
{
    $type = Type::of($object_or_class);

    try {
        $reflector = match ($type) {
            Type::Object => new ReflectionObject($object_or_class),
            Type::String => new ReflectionClass($object_or_class),
            default      => null,
        };
    } catch (ReflectionException $e) {
        return false;
    }

    if (null === $reflector) {
        return false;
    }

    return ! empty(
        $reflector->getAttributes(
            $attribute,
            ReflectionAttribute::IS_INSTANCEOF,
        )
    );
}

/**
 * Checks whether an object or class uses a given trait.
 *
 * @package Types\Traits
 *
 * @param  object|string  $object_or_class
 *   A class name or an object instance.
 *
 * @param  string  $trait
 *   The trait name.
 *
 * @param  bool  $allow_string
 *   If this parameter is set to `false`, a string class name as
 *   __object_or_class__ is not allowed. This also prevents from calling
 *   autoloader if the class doesn't exist.
 *
 * @return bool
 *   This function returns `true` if __object_or_class__, any of its traits,
 *   any of its parents, or its parents' traits, use __trait__. `false`
 *   otherwise.
 */
function uses(
    object|string $object_or_class,
    string $trait,
    bool $allow_string = true,
): bool {
    if (false === $allow_string && is_string($object_or_class)) {
        return false;
    }

    return isset(
        class_traits_uses($object_or_class, $allow_string)[$trait],
    ) || isset(
        class_parents_traits_uses($object_or_class, $allow_string)[$trait],
    );
}
