<?php

declare(strict_types=1);

namespace Tests\Unit;

use empaphy\usephul\UnhandledFitException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Samples\SampleStringable;
use Tests\TestCase;

#[CoversClass(UnhandledFitException::class)]
class UnhandledFitExceptionTest extends TestCase
{
    public static function dataProvider(): array
    {
        $foo = new SampleStringable('foo');
        $bar = new class {
            public string $qux = 'QUX';
            public string $baz = 'BAZ';
        };

        return [ // @formatter:off
            [$bar,  [fn(int    $v) => $v], "Unhandled fit value: class@anonymous Object\n"
                . "(\n    [qux] => QUX\n    [baz] => BAZ\n)\n"],
            [$foo,  [fn(int    $v) => $v], 'Unhandled fit value: foo'],
            ['foo', [fn(int    $v) => $v], 'Unhandled fit value: foo'],
            [0,     [fn(string $v) => $v], 'Unhandled fit value: 0'],
        ]; // @formatter:on
    }

    #[DataProvider('dataProvider')]
    public function testUnhandledFitException(mixed $subject, array $callbacks, string $expectedMessage): void
    {
        $unhandledFitException = new UnhandledFitException($subject, $callbacks);
        $this->assertEquals($expectedMessage, $unhandledFitException->getMessage());
    }
}
