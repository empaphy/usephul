<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;
use ValueError;

use function empaphy\usephul\Path\suffix;

#[CoversFunction('empaphy\usephul\Path\suffix')]
class SuffixTest extends TestCase
{
    public function testUsesHyphenAsDefaultSeparator(): void
    {
        $suffix = suffix('foo-suf.ext');
        $this->assertEquals('-suf', $suffix);
    }

    #[DataProviderExternal(Datasets\Suffix::class, 'dataProvider')]
    public function testReturnsSuffix(string $path, array $separators, string $expected): void
    {
        $suffix = suffix($path, ...$separators);
        $this->assertEquals($expected, $suffix);
    }

    public function testThrowsValueErrorWithEmptySeparator(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Argument #2 ($separator) must not be empty');
        suffix('foo-suf.ext', '');
    }

    public function testThrowsValueErrorWithVariableArguments(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Argument #3 (...$separators[0]) must not be empty');
        suffix('foo-suf.ext', '-', '');
    }

    public function testThrowsValueErrorWithNamedArguments(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Argument #3 (...$separators[\'foo\']) must not be empty');
        suffix('foo-suf.ext', '-', foo: '');
    }
}
