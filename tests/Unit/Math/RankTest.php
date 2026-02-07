<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace Tests\Unit\Math;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Samples\SampleCountable;
use Tests\Samples\SampleIntBackedEnum;
use Tests\Samples\SampleStringable;
use Tests\Samples\SampleStringBackedEnum;
use Tests\Samples\SampleUnitEnum;
use Tests\TestCase;

use function empaphy\usephul\Math\rank;

#[CoversFunction('empaphy\usephul\Math\rank')]
class RankTest extends TestCase
{
    public static function dataProvider(): array
    {
        $foo = SampleIntBackedEnum::Foo;
        $bar = SampleIntBackedEnum::Bar;
        $baz = SampleStringBackedEnum::Baz;
        $qux = SampleStringBackedEnum::Qux;
        $grault = SampleUnitEnum::Grault;
        $garply = SampleUnitEnum::Garply;
        $plugh = new SampleStringable('plugh');
        $xyzzy = new SampleStringable('xyzzy');
        $eleven = new SampleCountable(11);
        $thirteen = new SampleCountable(13);
        $object = new class {
            public string $quux = 'quux';
        };

        return [ //@formatter:off
            [null, 0],
            [false, 0],
            [true, 1],
            [2, 2],
            [3.5, 3.5],
            [$foo, $foo->value],
            [$baz, $baz->value],
            [$grault, $grault->name],
            [$plugh, (string) $plugh],
            [$eleven, count($eleven)],
            [$object, ['quux' => 'quux']],
            [
                [null, false, true, 17, 19.23, $bar,        $qux,        $garply,       $xyzzy, $thirteen],
                [   0,     0,    1, 17, 19.23, $bar->value, $qux->value, $garply->name, 'xyzzy',       13],
            ],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testReturnsExpectedValue(mixed $value, int|float|string|array $expected): void
    {
        $actual = rank($value);
        $this->assertEquals($expected, $actual);
    }

    public function testConvertsDateTimeRelatedObjectsToSecondsAsFloat(): void
    {
        $start = new DateTimeImmutable();
        $interval = new DateInterval('P1D');
        $end = (new DateTimeImmutable())->add(new DateInterval('P2D'));
        $datePeriod = new DatePeriod($start, $interval, $end);

        $monoStart = rank($start);
        $monoInterval = rank($interval);
        $monoEnd = rank($end);
        $monoPeriod = rank($datePeriod);

        $this->assertIsFloat($monoStart);
        $this->assertIsFloat($monoInterval);
        $this->assertIsFloat($monoEnd);
        $this->assertIsFloat($monoPeriod);
    }

    public function testThrowsInvalidArgumentExceptionForUnsupportedValue(): void
    {
        $handle = fopen('php://memory', 'rb+');
        $this->expectException(InvalidArgumentException::class);
        rank($handle);
    }
}
