<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use empaphy\usephul\Var\Type;
use Tests\Samples\SampleClass;

use function assert;
use function fclose;
use function fopen;
use function is_resource;

use const empaphy\usephul\ZEND_STR_ARRAY;
use const empaphy\usephul\ZEND_STR_BOOLEAN;
use const empaphy\usephul\ZEND_STR_CLOSED_RESOURCE;
use const empaphy\usephul\ZEND_STR_DOUBLE;
use const empaphy\usephul\ZEND_STR_INTEGER;
use const empaphy\usephul\ZEND_STR_NULL;
use const empaphy\usephul\ZEND_STR_OBJECT;
use const empaphy\usephul\ZEND_STR_RESOURCE;
use const empaphy\usephul\ZEND_STR_STRING;

class TypeData
{
    public static function casesProvider(): array
    {
        $closedResource = fopen(__FILE__, 'rb');
        assert(is_resource($closedResource));
        fclose($closedResource);
        $openResource = fopen(__FILE__, 'rb');

        return [ //@formatter:off
            'NULL'              => [null,              Type::Null],
            'true'              => [true,              Type::Boolean],
            'false'             => [false,             Type::Boolean],
            'integer'           => [PHP_INT_MAX,       Type::Integer],
            'float'             => [PHP_FLOAT_EPSILON, Type::Float],
            'string'            => ['foo',             Type::String],
            'object'            => [new SampleClass(), Type::Object],
            'resource'          => [$openResource,     Type::Resource],
            'resource (closed)' => [$closedResource,   Type::ClosedResource],
        ]; //@formatter:on
    }

    public static function failCasesProvider(): array
    {
        $closedResource = fopen(__FILE__, 'rb');
        assert(is_resource($closedResource));
        fclose($closedResource);
        $openResource = fopen(__FILE__, 'rb');

        return [ //@formatter:off
            'false != NULL'                 => [false,           Type::Null],
            'null  != boolean'              => [null,            Type::Boolean],
            '1     != boolean'              => [1,               Type::Boolean],
            '0     != boolean'              => [0,               Type::Boolean],
            '"7"   != integer'              => ['7',             Type::Integer],
            'null  != integer'              => [null,            Type::Integer],
            '7     != float'                => [7,               Type::Float],
            '0xF00 != string'               => [0xF00,           Type::String],
            '[]    != object'               => [[],              Type::Object],
            'resource (closed) != resource' => [$closedResource, Type::Resource],
            'resource != resource (closed)' => [$openResource,   Type::ClosedResource],
        ]; //@formatter:on
    }

    public static function valuesProvider(): array
    {
        return [ //@formatter:off
            [Type::Null,           ZEND_STR_NULL],
            [Type::Boolean,        ZEND_STR_BOOLEAN],
            [Type::Integer,        ZEND_STR_INTEGER],
            [Type::Float,          ZEND_STR_DOUBLE],
            [Type::String,         ZEND_STR_STRING],
            [Type::Array,          ZEND_STR_ARRAY],
            [Type::Object,         ZEND_STR_OBJECT],
            [Type::Resource,       ZEND_STR_RESOURCE],
            [Type::ClosedResource, ZEND_STR_CLOSED_RESOURCE],
            [Type::Unknown,        'unknown type'],
        ]; //@formatter:on
    }
}
