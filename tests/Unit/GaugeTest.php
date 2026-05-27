<?php

/**
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace Tests\Unit;

use Closure;
use empaphy\usephul\Fallback;
use empaphy\usephul\Gauge;
use empaphy\usephul\UnhandledFitException;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\Fixtures\Fit\Bar;
use Tests\Fixtures\Fit\Foo;
use Tests\Fixtures\Fit\FooBar;
use Tests\Fixtures\Fit\IBar;
use Tests\Fixtures\Fit\IFoo;
use Tests\TestCase;

use const empaphy\usephul\fallback;

#[CoversClass(Gauge::class)]
#[UsesClass(UnhandledFitException::class)]
class GaugeTest extends TestCase
{
    /**
     * @formatter:off
     */
    public static function fitArgumentsProvider(): array
    {
        $myFoo = new class implements IFoo {};
        $foo = new Foo();
        $bar = new Bar();
        $fooBar = new FooBar();
        $e = new Exception();

        return [
            [false,             [fn(bool       $_) => 1009], 1009],
            [true,              [fn(bool       $_) => 1013], 1013],
            ['foo',             [fn(string     $_) => 1019], 1019],
            ['foo',             [fn(string|int $_) => 1021], 1021],
            [[997],             [fn(array      $_) => 1087], 1087],
            [[],                [fn(array      $_) => 1091], 1091],
            [1031,              [fn(string|int $v) => $v],   1031],
            [5.67,              [fn(float      $v) => 8.97], 8.97],
            [1033,              [fn(int|string $_) => 1039], 1039],
            [$myFoo,            [fn(IFoo       $v) => $v],   $myFoo],
            [$foo,              [fn(Foo|Bar    $v) => $v],   $foo],
            [$bar,              [fn(Foo|Bar    $v) => $v],   $bar],
            [$fooBar,           [fn(IFoo&IBar  $v) => $v],   $fooBar],
            [Fallback::default, [fn(Fallback   $v) => $v],   fallback],

            [1049,  [fn(string $_) => throw $e, fn(int    $_) => 1051],     1051],
            [1061,  [fn(Foo    $_) => throw $e, fn(mixed  $_) => 1063],     1063],
            ['foo', [fn(string $_) => 1069,     fn(string $_) => throw $e], 1069],
        ];
    }

    /**
     * @formatter:on
     *
     * @template TResult
     * @template TSubject
     * @template TFit of TSubject
     *
     * @param  TSubject  $subject
     * @param  array<Closure(TFit $arg, TFit ...$args): TResult>  $callbacks
     * @param  TResult  $expected
     */
    #[DataProvider('fitArgumentsProvider')]
    public function testFit(mixed $subject, array $callbacks, mixed $expected): void
    {
        $gauge = new Gauge($subject);
        $actual = $gauge->is(...$callbacks);
        $this->assertSame($expected, $actual);
    }

    /**
     * @formatter:off
     */
    public static function unfitArgumentsProvider(): array
    {
        $myFoo = new class implements IFoo {};
        $foo = new Foo();
        $bar = new Bar();

        return [
            ['foo',  [fn(int        $v) => $v]],
            [$foo,   [fn(string|int $v) => $v]],
            [1031,   [fn(string     $v) => $v]],
            [1033,   [fn(string     $v) => $v, fn(string $v) => $v]],
            [$myFoo, [fn(IBar       $v) => $v]],
            [$foo,   [fn(Bar        $v) => $v]],
            [$bar,   [fn(Foo        $v) => $v]],
            [$foo,   [fn(IFoo&IBar  $v) => $v]],
            ['foo',  [fn(Foo        $v) => throw new Exception()]],
        ];
    }

    /**
     * @formatter:on
     *
     * @param  array<Closure(mixed $arg, mixed ...$args): mixed>  $callbacks
     */
    #[DataProvider('unfitArgumentsProvider')]
    public function testFitThrowsExceptionWhenSubjectIsUnfit(mixed $subject, array $callbacks): void
    {
        $this->expectException(UnhandledFitException::class);
        $gauge = new Gauge($subject);
        $gauge->is(...$callbacks);
    }

    public function testFitThrowsExceptionWhenTypeDeclarationIsMissing(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $gauge = new Gauge('foo');
        $gauge->is(fn($v) => $v);
    }

    public function testFitThrowsExceptionWhenCallbackHasNoParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $gauge = new Gauge('foo');
        $gauge->is(fn() => 'bar');
    }
}
