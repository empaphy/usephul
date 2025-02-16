<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Other
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * Return the traits used by the parent classes of the given class.
 *
 * This function returns an array with the names of the traits that the parents
 * of the given **object_or_class** use.
 *
 * @package Other\SPL
 *
 * @param  object|string  $object_or_class  An object or class name.
 * @param  bool           $autoload     Whether to
 *                                      {@link http://php.net/autoload autoload}
 *                                      if not already loaded.
 * @return array<class-string, class-string>|false An array on success, or false
 *                                                 when the class doesn't exist.
 */
function class_parents_uses(
    object|string $object_or_class,
    bool $autoload = true
): array|false {
    $parents = \class_parents($object_or_class, $autoload);

    if (false === $parents) {
        return false;
    }

    $traits = [];
    foreach ($parents as $parent) {
        $traits += \class_uses($parent) ?: [];
    }

    return $traits;
}

/**
 * Return the traits used by the parent classes of the given class, recursively.
 *
 * This function returns an array with the names of the traits that the parent
 * classes of the given **object_or_class** uses, including traits used within
 * those traits.
 *
 * @param  object|string  $object_or_class  An object or class name.
 * @param  bool           $autoload     Whether to
 *                                      {@link http://php.net/autoload autoload}
 *                                      if not already loaded.
 * @return array<class-string, class-string>|false An array on success, or false
 *                                                 when the class doesn't exist.
 *@package Other\SPL
 *
 */
function class_parents_traits_uses(
    object|string $object_or_class,
    bool $autoload = true
): array|false {
    $parents = \class_parents($object_or_class, $autoload);

    if (false === $parents) {
        return false;
    }

    $traits = [];
    foreach ($parents as $parent) {
        $traits += class_traits_uses($parent) ?: [];
    }

    return $traits;
}


/**
 * Return the traits used by the given class or trait, recursively.
 *
 * This function returns an array with the names of the traits that the given
 * **object_or_class** uses, including traits used by those traits, recursively.
 * This does however not include any traits used by a parent class.
 *
 * @package Other\SPL
 *
 * @param  object|string  $object_or_class  An object, class name or trait name.
 * @param  bool           $autoload    Whether to
 *                                     {@link https://php.net/autoload autoload}
 *                                     if not already loaded.
 * @return array<class-string, class-string>|false An array on success, or false
 *                                                 when the class doesn't exist.
 */
function class_traits_uses(
    object|string $object_or_class,
    bool $autoload = true
): array|false {
    $uses = \class_uses($object_or_class, $autoload);
    if (false === $uses) {
        return false;
    }

    foreach ($uses as $use) {
        $uses += class_traits_uses($use, $autoload) ?: [];
    }

    return $uses;
}
