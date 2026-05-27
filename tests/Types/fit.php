<?php

/**
 * @noinspection PhpExpressionResultUnusedInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace Tests\Types;

use empaphy\usephul\Gauge;
use Tests\Fixtures\Fit\Foo;

use function empaphy\usephul\fit;
use function PHPStan\Testing\assertType;

function () {
    /** @var int|string $subject */
    $subject = 1;
    $value = fit(
        $subject,
        fn(int $value): int => $value,
        fn(string $value): string => $value,
    );

    assertType('int|string', $value);
};

function () {
    /** @var int|string $subject */
    $subject = 1;
    $value = fit(
        $subject,
        fn(int $value): int => $value,
        fn(string $_): string => 'fallback',
    );

    assertType("'fallback'|int", $value);
};

// Test whether `fit()` inferst nullable object return type from heterogeneous callbacks.
function () {
    /** @var int|string $subject */
    $subject = 1;
    $value = fit(
        $subject,
        fn(int $value): ?Foo => $value > 0 ? new Foo() : null,
        fn(string $_): bool => true,
        fn(mixed $_): mixed => null,
    );

    assertType(Foo::class . '|true|null', $value);
};

function () {
    assertType(Gauge::class . '<null>', fit(null));
    assertType(Gauge::class . '<bool>', fit(false));
    assertType(Gauge::class . '<bool>', fit(true));
    assertType(Gauge::class . '<int>', fit(1));
    assertType(Gauge::class . '<float>', fit(1.2));
    assertType(Gauge::class . '<string>', fit('foo'));
    assertType(Gauge::class . '<array{int}>', fit([1]));
    assertType(Gauge::class . '<' . Foo::class . '>', fit(new Foo()));
};
