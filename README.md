# Usephul
[![Tests](https://github.com/empaphy/usephul/actions/workflows/tests.yml/badge.svg)](https://github.com/empaphy/usephul/actions/workflows/tests.yml)
[![Quality](https://github.com/empaphy/usephul/actions/workflows/quality.yml/badge.svg)](https://github.com/empaphy/usephul/actions/workflows/quality.yml)

**Usephul** is a PHP library that provides useful classes and functions that extend the standard functionality of PHP.

## Functions

### Array Functions

  - [array_exclude()](https://usephul.empaphy.org/packages/Arrays.html#function_array_exclude)
    — exclude values from an array.
  - [array_extract()](https://usephul.empaphy.org/packages/Arrays.html#function_array_extract)
    — Extract values from an array.
  - [array_interchange()](https://usephul.empaphy.org/packages/Arrays.html#function_array_interchange)
    — Interchange the values of two elements of an array.
  - [array_key_types()](https://usephul.empaphy.org/packages/Arrays.html#function_array_key_types)
    — Inspects the types of keys used in an array.
  - [array_omit()](https://usephul.empaphy.org/packages/Arrays.html#function_array_omit)
    — Omit keys from an array.
  - [array_pick()](https://usephul.empaphy.org/packages/Arrays.html#function_array_pick)
    — Pick keys from an array.
  - [array_remap()](https://usephul.empaphy.org/packages/Arrays.html#function_array_remap)
    — Applies a (generator) callback to the elements of a given array, allowing the remapping of its keys in the process.
  - [array_zip()](https://usephul.empaphy.org/packages/Arrays.html#function_array_zip)
    — Perform a zip operation on multiple arrays.

### Path Functions

  - [Path\basename()](https://usephul.empaphy.org/packages/Paths.html#function_basename)
    — Returns the trailing name component of a path.
  - [Path\components()](https://usephul.empaphy.org/packages/Paths.html#function_components)
    — Returns an array of path components for the given path.
  - [Path\dirname()](https://usephul.empaphy.org/packages/Paths.html#function_dirname)
    — Returns a parent directory's path.
  - [Path\extension()](https://usephul.empaphy.org/packages/Paths.html#function_extension)
    — Returns the extension component of a path.
  - [Path\extension_replace()](https://usephul.empaphy.org/packages/Paths.html#function_extension_replace)
    — Replaces the extension component of a path with something else.
  - [Path\filename()](https://usephul.empaphy.org/packages/Paths.html#function_filename)
    — Returns the name component of a path without the extension.
  - [Path\suffix()](https://usephul.empaphy.org/packages/Paths.html#function_suffix)
    — Returns a suffix for a path based on a given set of separators.

### Generator Functions

  - [seq()](https://usephul.empaphy.org/packages/Generators.html#function_seq)
    — Sequences a value into a [Generator](https://www.php.net/generators).

### Math Functions

  - [greatest()](https://usephul.empaphy.org/packages/Math.html#function_greatest)
    — Finds the value that is greater than all the other values.
  - [least()](https://usephul.empaphy.org/packages/Math.html#function_least)
    — Finds the value that is less than all the other values.
  - [rank()](https://usephul.empaphy.org/packages/Math.html#function_rank)
    — Returns the ordinal rank for a given value.

### Variable handling Functions

  - [is_closed_resource()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_closed_resource)
    — Finds whether the given variable is a [resource](https://www.php.net/types.resource) that has been closed.
  - [is_non_empty_string()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_non_empty_string)
    — Find whether a variable is a non-empty string.
  - [is_negative_int()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_negative_int)
    — Find whether a variable is an integer and less than zero.
  - [is_non_negative_int()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_non_negative_int)
    — Find whether a variable is an integer and not less than zero.
  - [is_non_positive_int()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_non_positive_int)
    — Find whether a variable is an integer and not greater than zero.
  - [is_non_zero_int()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_non_zero_int)
    — Find whether a variable is an integer and not zero.
  - [is_number()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_number)
    — Find whether a variable is a number (either an integer or a float).
  - [is_positive_int()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_positive_int)
    — Find whether a variable is an integer and greater than zero.
  - [is_zero()](https://usephul.empaphy.org/packages/Types-Variables.html#function_is_zero)
    — Finds whether the given number is (sufficiently close to) 0.

### Attribute Functions

  - [applies()](https://usephul.empaphy.org/packages/Types-Attributes.html#function_applies)
    — Finds whether an attribute has been applied to a given object, class, interface, or trait.

### Trait Functions

  - [uses()](https://usephul.empaphy.org/packages/Types-Traits.html#function_uses)
    — Checks whether an object or class uses a given trait.

### SPL Functions

  - [class_parents_uses()](https://usephul.empaphy.org/packages/Other-SPL.html#function_class_parents_uses)
    — Return the traits used by the parent classes of the given class.
  - [class_parents_traits_uses()](https://usephul.empaphy.org/packages/Other-SPL.html#function_class_parents_traits_uses)
    — Return the traits used by the parent classes of the given class, recursively.
  - [class_traits_uses()](https://usephul.empaphy.org/packages/Other-SPL.html#function_class_traits_uses)
    — Return the traits used by the given class or trait, recursively.

## Classes

### Paths

  - [PathInfo](http://localhost:63342/usephul/.phpdoc/build/classes/empaphy-usephul-Paths-PathInfo.html)
    — Provides information about a file path.

## Traits

### Enumerations

  - [EnumDynamicity](https://usephul.empaphy.org/classes/empaphy-usephul-Enumerations-EnumDynamicity.html)
    — Adds dynamicity of case names to PHP Enumerations.
