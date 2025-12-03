<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Constants
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * This mask matches every possible past and future PHP error level.
 */
const E_EVERYTHING = 0x7FFFFFFF;

const ZEND_STR_FILE                   = 'file';
const ZEND_STR_LINE                   = 'line';
const ZEND_STR_FUNCTION               = 'function';
const ZEND_STR_CLASS                  = 'class';
const ZEND_STR_OBJECT                 = 'object';
const ZEND_STR_TYPE                   = 'type';
const ZEND_STR_OBJECT_OPERATOR        = '->';
const ZEND_STR_PAAMAYIM_NEKUDOTAYIM   = '::';
const ZEND_STR_ARGS                   = 'args';
const ZEND_STR_UNKNOWN                = 'unknown';
const ZEND_STR_UNKNOWN_CAPITALIZED    = 'Unknown';
const ZEND_STR_EXIT                   = 'exit';
const ZEND_STR_EVAL                   = 'eval';
const ZEND_STR_INCLUDE                = 'include';
const ZEND_STR_REQUIRE                = 'require';
const ZEND_STR_INCLUDE_ONCE           = 'include_once';
const ZEND_STR_REQUIRE_ONCE           = 'require_once';
const ZEND_STR_SCALAR                 = 'scalar';
const ZEND_STR_ERROR_REPORTING        = 'error_reporting';
const ZEND_STR_STATIC                 = 'static';
const ZEND_STR_THIS                   = 'this';
const ZEND_STR_VALUE                  = 'value';
const ZEND_STR_KEY                    = 'key';
const ZEND_STR_MAGIC_INVOKE           = '__invoke';
const ZEND_STR_PREVIOUS               = 'previous';
const ZEND_STR_CODE                   = 'code';
const ZEND_STR_MESSAGE                = 'message';
const ZEND_STR_SEVERITY               = 'severity';
const ZEND_STR_STRING                 = 'string';
const ZEND_STR_TRACE                  = 'trace';
const ZEND_STR_SCHEME                 = 'scheme';
const ZEND_STR_HOST                   = 'host';
const ZEND_STR_PORT                   = 'port';
const ZEND_STR_USER                   = 'user';
const ZEND_STR_PASS                   = 'pass';
const ZEND_STR_PATH                   = 'path';
const ZEND_STR_QUERY                  = 'query';
const ZEND_STR_FRAGMENT               = 'fragment';
const ZEND_STR_NULL                   = 'NULL';
const ZEND_STR_BOOLEAN                = 'boolean';
const ZEND_STR_INTEGER                = 'integer';
const ZEND_STR_DOUBLE                 = 'double';
const ZEND_STR_ARRAY                  = 'array';
const ZEND_STR_RESOURCE               = 'resource';
const ZEND_STR_CLOSED_RESOURCE        = 'resource (closed)';
const ZEND_STR_NAME                   = 'name';
const ZEND_STR_ARGV                   = 'argv';
const ZEND_STR_ARGC                   = 'argc';
const ZEND_STR_ARRAY_CAPITALIZED      = 'Array';
const ZEND_STR_BOOL                   = 'bool';
const ZEND_STR_INT                    = 'int';
const ZEND_STR_FLOAT                  = 'float';
const ZEND_STR_CALLABLE               = 'callable';
const ZEND_STR_ITERABLE               = 'iterable';
const ZEND_STR_VOID                   = 'void';
const ZEND_STR_NEVER                  = 'never';
const ZEND_STR_FALSE                  = 'false';
const ZEND_STR_TRUE                   = 'true';
const ZEND_STR_NULL_LOWERCASE         = 'null';
const ZEND_STR_MIXED                  = 'mixed';
const ZEND_STR_TRAVERSABLE            = 'Traversable';
const ZEND_STR_SLEEP                  = '__sleep';
const ZEND_STR_WAKEUP                 = '__wakeup';
const ZEND_STR_CASES                  = 'cases';
const ZEND_STR_FROM                   = 'from';
const ZEND_STR_TRYFROM                = 'tryFrom';
const ZEND_STR_TRYFROM_LOWERCASE      = 'tryfrom';
const ZEND_STR_AUTOGLOBAL_SERVER      = '_SERVER';
const ZEND_STR_AUTOGLOBAL_ENV         = '_ENV';
const ZEND_STR_AUTOGLOBAL_REQUEST     = '_REQUEST';
const ZEND_STR_COUNT                  = 'count';
const ZEND_STR_SENSITIVEPARAMETER     = 'SensitiveParameter';
const ZEND_STR_CONST_EXPR_PLACEHOLDER = '[constant expression]';
const ZEND_STR_DEPRECATED_CAPITALIZED = 'Deprecated';
const ZEND_STR_SINCE                  = 'since';
const ZEND_STR_GET                    = 'get';
const ZEND_STR_SET                    = 'set';

const ZEND_KNOWN_STRINGS = [
    ZEND_STR_FILE                   => ZEND_STR_FILE,
    ZEND_STR_LINE                   => ZEND_STR_LINE,
    ZEND_STR_FUNCTION               => ZEND_STR_FUNCTION,
    ZEND_STR_CLASS                  => ZEND_STR_CLASS,
    ZEND_STR_OBJECT                 => ZEND_STR_OBJECT,
    ZEND_STR_TYPE                   => ZEND_STR_TYPE,
    ZEND_STR_OBJECT_OPERATOR        => ZEND_STR_OBJECT_OPERATOR,
    ZEND_STR_PAAMAYIM_NEKUDOTAYIM   => ZEND_STR_PAAMAYIM_NEKUDOTAYIM,
    ZEND_STR_ARGS                   => ZEND_STR_ARGS,
    ZEND_STR_UNKNOWN                => ZEND_STR_UNKNOWN,
    ZEND_STR_UNKNOWN_CAPITALIZED    => ZEND_STR_UNKNOWN_CAPITALIZED,
    ZEND_STR_EXIT                   => ZEND_STR_EXIT,
    ZEND_STR_EVAL                   => ZEND_STR_EVAL,
    ZEND_STR_INCLUDE                => ZEND_STR_INCLUDE,
    ZEND_STR_REQUIRE                => ZEND_STR_REQUIRE,
    ZEND_STR_INCLUDE_ONCE           => ZEND_STR_INCLUDE_ONCE,
    ZEND_STR_REQUIRE_ONCE           => ZEND_STR_REQUIRE_ONCE,
    ZEND_STR_SCALAR                 => ZEND_STR_SCALAR,
    ZEND_STR_ERROR_REPORTING        => ZEND_STR_ERROR_REPORTING,
    ZEND_STR_STATIC                 => ZEND_STR_STATIC,
    ZEND_STR_THIS                   => ZEND_STR_THIS,
    ZEND_STR_VALUE                  => ZEND_STR_VALUE,
    ZEND_STR_KEY                    => ZEND_STR_KEY,
    ZEND_STR_MAGIC_INVOKE           => ZEND_STR_MAGIC_INVOKE,
    ZEND_STR_PREVIOUS               => ZEND_STR_PREVIOUS,
    ZEND_STR_CODE                   => ZEND_STR_CODE,
    ZEND_STR_MESSAGE                => ZEND_STR_MESSAGE,
    ZEND_STR_SEVERITY               => ZEND_STR_SEVERITY,
    ZEND_STR_STRING                 => ZEND_STR_STRING,
    ZEND_STR_TRACE                  => ZEND_STR_TRACE,
    ZEND_STR_SCHEME                 => ZEND_STR_SCHEME,
    ZEND_STR_HOST                   => ZEND_STR_HOST,
    ZEND_STR_PORT                   => ZEND_STR_PORT,
    ZEND_STR_USER                   => ZEND_STR_USER,
    ZEND_STR_PASS                   => ZEND_STR_PASS,
    ZEND_STR_PATH                   => ZEND_STR_PATH,
    ZEND_STR_QUERY                  => ZEND_STR_QUERY,
    ZEND_STR_FRAGMENT               => ZEND_STR_FRAGMENT,
    ZEND_STR_NULL                   => ZEND_STR_NULL,
    ZEND_STR_BOOLEAN                => ZEND_STR_BOOLEAN,
    ZEND_STR_INTEGER                => ZEND_STR_INTEGER,
    ZEND_STR_DOUBLE                 => ZEND_STR_DOUBLE,
    ZEND_STR_ARRAY                  => ZEND_STR_ARRAY,
    ZEND_STR_RESOURCE               => ZEND_STR_RESOURCE,
    ZEND_STR_CLOSED_RESOURCE        => ZEND_STR_CLOSED_RESOURCE,
    ZEND_STR_NAME                   => ZEND_STR_NAME,
    ZEND_STR_ARGV                   => ZEND_STR_ARGV,
    ZEND_STR_ARGC                   => ZEND_STR_ARGC,
    ZEND_STR_ARRAY_CAPITALIZED      => ZEND_STR_ARRAY_CAPITALIZED,
    ZEND_STR_BOOL                   => ZEND_STR_BOOL,
    ZEND_STR_INT                    => ZEND_STR_INT,
    ZEND_STR_FLOAT                  => ZEND_STR_FLOAT,
    ZEND_STR_CALLABLE               => ZEND_STR_CALLABLE,
    ZEND_STR_ITERABLE               => ZEND_STR_ITERABLE,
    ZEND_STR_VOID                   => ZEND_STR_VOID,
    ZEND_STR_NEVER                  => ZEND_STR_NEVER,
    ZEND_STR_FALSE                  => ZEND_STR_FALSE,
    ZEND_STR_TRUE                   => ZEND_STR_TRUE,
    ZEND_STR_NULL_LOWERCASE         => ZEND_STR_NULL_LOWERCASE,
    ZEND_STR_MIXED                  => ZEND_STR_MIXED,
    ZEND_STR_TRAVERSABLE            => ZEND_STR_TRAVERSABLE,
    ZEND_STR_SLEEP                  => ZEND_STR_SLEEP,
    ZEND_STR_WAKEUP                 => ZEND_STR_WAKEUP,
    ZEND_STR_CASES                  => ZEND_STR_CASES,
    ZEND_STR_FROM                   => ZEND_STR_FROM,
    ZEND_STR_TRYFROM                => ZEND_STR_TRYFROM,
    ZEND_STR_TRYFROM_LOWERCASE      => ZEND_STR_TRYFROM_LOWERCASE,
    ZEND_STR_AUTOGLOBAL_SERVER      => ZEND_STR_AUTOGLOBAL_SERVER,
    ZEND_STR_AUTOGLOBAL_ENV         => ZEND_STR_AUTOGLOBAL_ENV,
    ZEND_STR_AUTOGLOBAL_REQUEST     => ZEND_STR_AUTOGLOBAL_REQUEST,
    ZEND_STR_COUNT                  => ZEND_STR_COUNT,
    ZEND_STR_SENSITIVEPARAMETER     => ZEND_STR_SENSITIVEPARAMETER,
    ZEND_STR_CONST_EXPR_PLACEHOLDER => ZEND_STR_CONST_EXPR_PLACEHOLDER,
    ZEND_STR_DEPRECATED_CAPITALIZED => ZEND_STR_DEPRECATED_CAPITALIZED,
    ZEND_STR_SINCE                  => ZEND_STR_SINCE,
    ZEND_STR_GET                    => ZEND_STR_GET,
    ZEND_STR_SET                    => ZEND_STR_SET,
];

/**
 * Represents a fallback value.
 *
 * It is actually just a reference to the {@see Fallback::default default}
 * {@see Fallback} case.
 *
 * Conceptually, `fallback` indicates the lack of an operation having been
 * performed on a variable. This is useful in cases where any value is
 * considered valid (even `null`), and you need to distinguish between "no value
 * provided" and "value explicitly set to `null`".
 *
 * One use case for `fallback` is as a default value for functions that attempt
 * to retrieve a value without a guarantee and accept a "default" argument:
 *
 *     $value = config('some_key', fallback);
 *     if ($value === fallback) {
 *         // 'some_key' was not found
 *     }
 *
 * You can also use the {@see Fallback} enum as a type hint:
 *
 *     function example(string|null|Fallback $param = fallback): void {}
 *
 */
const fallback = Fallback::default;
