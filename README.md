# Usephul
[![Test Suite](https://github.com/empaphy/usephul/actions/workflows/test-suite.yml/badge.svg)](https://github.com/empaphy/usephul/actions/workflows/test-suite.yml)

**Usephul** is a PHP library that provides useful classes and functions that extend the standard functionality of PHP.

## Functions

### Array Functions

  - [array_interchange()](https://usephul.empaphy.org/packages/Arrays.html#function_array_interchange)
    — Interchange the values of two elements of an array.
  - [array_remap()](https://usephul.empaphy.org/packages/Arrays.html#function_array_remap)
    — Applies a (generator) callback to the elements of a given array, allowing the remapping of its keys in the process.
  - [array_zip()](https://usephul.empaphy.org/packages/Arrays.html#function_array_zip)
    — Perform a zip operation on multiple arrays.

### Filesystem Functions

  - [filename()](https://usephul.empaphy.org/packages/Filesystem.html#function_filename)
    — Returns the name component of path without the extension.
  - [extension()](https://usephul.empaphy.org/packages/Filesystem.html#function_extension)
    — Returns the extension component of path without the extension.

### Generator Functions

  - [seq()](https://usephul.empaphy.org/packages/Generators.html#function_seq)
    — Sequences a value into a [Generator](https://www.php.net/generators).

### Variable handling Functions

  - [is_closed_resource()](https://usephul.empaphy.org/packages/Types.html#function_is_closed_resource)
    — Finds whether the given variable is a [resource](https://www.php.net/types.resource) that has been closed.
  - [is_zero()](https://usephul.empaphy.org/packages/Types.html#function_is_zero)
    — Finds whether the given number is (sufficiently close to) 0.

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

### Filesystem

  - [PathInfo](http://localhost:63342/usephul/.phpdoc/build/classes/empaphy-usephul-Filesystem-PathInfo.html)
    — Provides information about a file path.

## Traits

### Enumerations

  - [EnumDynamicity](https://usephul.empaphy.org/classes/empaphy-usephul-Enumerations-EnumDynamicity.html)
    — Adds dynamicity of case names to PHP Enumerations.
