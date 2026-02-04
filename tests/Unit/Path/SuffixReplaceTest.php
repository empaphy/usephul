<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;
use ValueError;

use function empaphy\usephul\Path\suffix_replace;

#[CoversFunction('empaphy\usephul\Path\suffix_replace')]
class SuffixReplaceTest extends TestCase
{
    #[DataProviderExternal(Datasets\SuffixReplace::class, 'dataProvider')]
    public function testReplacesSuffixInPath(string $path, string $suffix, array $separators, string $expected): void
    {
        $actual = suffix_replace($path, $suffix, ...$separators);
        $this->assertSame($expected, $actual);
    }

    public function testThrowsValueErrorWithEmptySeparator(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Argument #3 (...$separators[0]) must not be empty');
        suffix_replace('foo-suf.ext', '-fix', '');
    }

    public function testThrowsValueErrorWithVariableArguments(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Argument #4 (...$separators[1]) must not be empty');
        suffix_replace('foo-suf.ext', '-fix', '-', '');
    }

    public function testThrowsValueErrorWithNamedArguments(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Argument #4 (...$separators[\'foo\']) must not be empty');
        suffix_replace('foo-suf.ext', '-fix', '-', foo: '');
    }
}
