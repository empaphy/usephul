<?php

/**
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

use Tests\Fixtures\SampleClass;

use function empaphy\usephul\Var\is_closed_resource;
use function PHPStan\Testing\assertType;

function () {
    $resource = fopen('php://memory', 'r+');
    assert(false !== $resource);
    fclose($resource);

    assertType('true', is_closed_resource($resource)); // @phpstan-ignore function.alreadyNarrowedType
};

function () {
    assertType('false', is_closed_resource(null));              // @phpstan-ignore function.impossibleType
    assertType('false', is_closed_resource(true));              // @phpstan-ignore function.impossibleType
    assertType('false', is_closed_resource(false));             // @phpstan-ignore function.impossibleType
    assertType('false', is_closed_resource(PHP_INT_MAX));       // @phpstan-ignore function.impossibleType
    assertType('false', is_closed_resource(PHP_FLOAT_EPSILON)); // @phpstan-ignore function.impossibleType
    assertType('false', is_closed_resource('foo'));             // @phpstan-ignore function.impossibleType
    assertType('false', is_closed_resource(new SampleClass())); // @phpstan-ignore function.impossibleType
};

function (mixed $resource) {
    assert(is_closed_resource($resource));
    assertType('resource', $resource);
};
