<?php

/**
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

use Tests\Fixtures\SampleUnitEnum;

use function empaphy\usephul\Var\is_enum_case;
use function PHPStan\Testing\assertType;

function (SampleUnitEnum $enumCase) {
    assertType('true', is_enum_case($enumCase));              // @phpstan-ignore function.alreadyNarrowedType
    assertType('true', is_enum_case(SampleUnitEnum::Garply)); // @phpstan-ignore function.alreadyNarrowedType
};

function (string $string) {
    assertType('false', is_enum_case($string)); // @phpstan-ignore function.impossibleType
    assertType('false', is_enum_case('foo'));   // @phpstan-ignore function.impossibleType
};

function (mixed $enumCase) {
    assert(is_enum_case($enumCase));
    assertType(UnitEnum::class, $enumCase);
};
