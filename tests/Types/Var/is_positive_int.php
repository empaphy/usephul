<?php

/**
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

use function empaphy\usephul\Var\is_positive_int;
use function PHPStan\Testing\assertType;

function () {
    assertType('true', is_positive_int(1)); // @phpstan-ignore function.alreadyNarrowedType
};

function () {
    assertType('false', is_positive_int(0));  // @phpstan-ignore function.impossibleType
    assertType('false', is_positive_int(-1)); // @phpstan-ignore function.impossibleType
};

function (mixed $value) {
    assert(is_positive_int($value));
    assertType('int<1, max>', $value);
};
