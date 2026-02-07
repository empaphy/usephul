<?php

/**
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpParamsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace Tests\Unit;

use ArgumentCountError;
use Closure;
use empaphy\usephul\UnhandledFitException;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\TestCase;
use Tests\Unit\Fit\Bar;
use Tests\Unit\Fit\BarInterface;
use Tests\Unit\Fit\Foo;
use Tests\Unit\Fit\FooBar;
use Tests\Unit\Fit\FooInterface;

use function empaphy\usephul\fit;

#[CoversFunction('empaphy\usephul\fit')]
#[UsesClass(UnhandledFitException::class)]
class FitTest extends TestCase
{
    public static function fitArgumentsProvider(): array
    {
        $myFoo = new class implements FooInterface {};
        $foo = new Foo();
        $bar = new Bar();
        $fooBar = new FooBar();

        return [
            ['foo', [fn(string $v) => $v], 'foo'],
            ['foo', [fn(string|int $v) => $v], 'foo'],
            [0, [fn(string|int $v) => $v], 0],
            [0, [fn(string $s) => $s, fn(int $i) => $i], 0],
            [$myFoo, [fn(FooInterface $v) => $v], $myFoo],
            [$foo, [fn(Foo|Bar $v) => $v], $foo],
            [$bar, [fn(Foo|Bar $v) => $v], $bar],
            [$fooBar, [fn(FooInterface&BarInterface $v) => $v], $fooBar],
            ['foo', [fn(Foo $v) => throw new Exception(), fn(mixed $v) => 'bar'], 'bar'],
            ['foo', [fn(string $v) => $v, fn(string $v) => $v], 'foo'],
        ];
    }

    /**
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
        $actual = fit($subject, ...$callbacks);
        $this->assertSame($expected, $actual);
    }

    public static function unfitArgumentsProvider(): array
    {
        $myFoo = new class implements FooInterface {};
        $foo = new Foo();
        $bar = new Bar();

        return [
            ['foo', [fn(int $v) => $v]],
            [$foo, [fn(string|int $v) => $v]],
            [0, [fn(string $v) => $v]],
            [0, [fn(string $s) => $s, fn(string $i) => $i]],
            [$myFoo, [fn(BarInterface $v) => $v]],
            [$foo, [fn(Bar $v) => $v]],
            [$bar, [fn(Foo $v) => $v]],
            [$foo, [fn(FooInterface&BarInterface $v) => $v]],
            ['foo', [fn(Foo $v) => throw new Exception()]],
        ];
    }

    /**
     * @param  array<Closure(mixed $arg, mixed ...$args): mixed>  $callbacks
     */
    #[DataProvider('unfitArgumentsProvider')]
    public function testFitThrowsExceptionWhenSubjectIsUnfit(mixed $subject, array $callbacks): void
    {
        $this->expectException(UnhandledFitException::class);
        fit($subject, ...$callbacks);
    }

    public function testFitThrowsExceptionWhenTypeDeclarationIsMissing(): void
    {
        $this->expectException(InvalidArgumentException::class);
        fit('foo', fn($v) => $v);
    }

    public function testFitThrowsExceptionWhenCallbackMissing(): void
    {
        $this->expectException(ArgumentCountError::class);
        fit('foo'); // @phpstan-ignore arguments.count,argument.templateType
    }

    public function testFitThrowsExceptionWhenCallbackHasNoParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        fit('foo', fn() => 'bar');
    }
}
