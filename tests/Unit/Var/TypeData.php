<?php

declare(strict_types=1);

namespace Tests\Unit\Var;

use empaphy\usephul\Var\Type;
use Tests\Samples\SampleClass;

use function assert;
use function fclose;
use function fopen;
use function is_resource;

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
            [Type::Null,           'NULL'],
            [Type::Boolean,        'boolean'],
            [Type::Integer,        'integer'],
            [Type::Float,          'double'],
            [Type::String,         'string'],
            [Type::Array,          'array'],
            [Type::Object,         'object'],
            [Type::Resource,       'resource'],
            [Type::ClosedResource, 'resource (closed)'],
            [Type::Unknown,        'unknown type'],
        ]; //@formatter:on
    }
}
