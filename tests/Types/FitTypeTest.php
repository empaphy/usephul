<?php

/**
 * @noinspection PhpExpressionResultUnusedInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace Tests\Types;

use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\fixtures\Fit\Foo;
use Tests\TestCase;

use function empaphy\usephul\fit;
use function function_exists;
use function PHPStan\Testing\assertType;

if (! function_exists('PHPStan\Testing\assertType')) {
    require_once 'phar://' . __DIR__ . '/../../vendor/phpstan/phpstan/phpstan.phar/src/Testing/functions.php';
}

#[CoversFunction('empaphy\usephul\fit')]
class FitTypeTest extends TestCase
{
    public function testInfersReturnTypeFromHeterogeneousCallbacks(): void
    {
        /** @var int|string $subject */
        $subject = 1;
        $value = fit(
            $subject,
            fn(int $value): int => $value,
            fn(string $value): string => $value,
        );

        assertType('int|string', $value);

        $this->addToAssertionCount(1);
    }

    public function testInfersLiteralReturnTypesFromHeterogeneousCallbacks(): void
    {
        /** @var int|string $subject */
        $subject = 1;
        $value = fit(
            $subject,
            fn(int $value): int => $value,
            fn(string $_): string => 'fallback',
        );

        assertType("'fallback'|int", $value);

        $this->addToAssertionCount(1);
    }

    public function testInfersNullableObjectReturnTypeFromHeterogeneousCallbacks(): void
    {
        /** @var int|string $subject */
        $subject = 1;
        $value = fit(
            $subject,
            fn(int $value): ?Foo => $value > 0 ? new Foo() : null,
            fn(string $_): bool => true,
            fn(mixed $_): mixed => null,
        );

        assertType(Foo::class . '|true|null', $value);

        $this->addToAssertionCount(1);
    }
}
