<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\usephul
 */

declare(strict_types=1);

use empaphy\usephul\Var\Type;

$closedResource = fopen(__FILE__, 'rb');
assert(is_resource($closedResource));
fclose($closedResource);
$openResource = fopen(__FILE__, 'rb');

dataset('types / test cases', [
    'NULL'              => [null,              Type::Null],
    'true'              => [true,              Type::Boolean],
    'false'             => [false,             Type::Boolean],
    'integer'           => [PHP_INT_MAX,       Type::Integer],
    'float'             => [PHP_FLOAT_EPSILON, Type::Float],
    'string'            => ['foo',             Type::String],
    'object'            => [new stdClass(),    Type::Object],
    'resource'          => [$openResource,     Type::Resource],
    'resource (closed)' => [$closedResource,   Type::ClosedResource],
]);

dataset('types / fail cases', [
    'false != NULL'    => [false, Type::Null],
    'null  != boolean' => [null,  Type::Boolean],
    '1     != boolean' => [1,     Type::Boolean],
    '0     != boolean' => [0,     Type::Boolean],
    '"7"   != integer' => ['7',   Type::Integer],
    'null  != integer' => [null,  Type::Integer],
    '7     != float'   => [7,     Type::Float],
    '0xF00 != string'  => [0xF00, Type::String],
    '[]    != object'  => [[],     Type::Object],
    'resource (closed) != resource' => [$closedResource, Type::Resource],
    'resource != resource (closed)' => [$openResource,   Type::ClosedResource],
]);

dataset('types / values', [
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
]);
