<?php

/**
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

use function empaphy\usephul\Var\is_negative_int;
use function PHPStan\Testing\assertType;

function () {
    assertType('true', is_negative_int(-1)); // @phpstan-ignore function.alreadyNarrowedType
};

function () {
    assertType('false', is_negative_int(0)); // @phpstan-ignore function.impossibleType
    assertType('false', is_negative_int(1)); // @phpstan-ignore function.impossibleType
};

function (mixed $value) {
    assert(is_negative_int($value));
    assertType('int<min, -1>', $value);
};
