<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\TestCase;

use function empaphy\usephul\Path\extension_replace;
use function empaphy\usephul\Var\is_non_empty_string;

#[CoversFunction('empaphy\usephul\Path\extension_replace')]
#[UsesFunction('empaphy\usephul\Var\is_non_empty_string')]
class ExtensionReplaceTest extends TestCase
{
    #[DataProviderExternal(Datasets\ExtensionReplaceDefaults::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\ExtensionReplaceEmptyReplacement::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\ExtensionReplaceWithDotPrefix::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\ExtensionReplaceWithDotPrefixAndReplacement::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\ExtensionReplaceWithHyphenPrefixAndReplacement::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\ExtensionReplaceWithReplacement::class, 'dataProvider')]
    public function testReplacesExtension(string $path, ?string $replacement, string $prefix, string $expected): void
    {
        $actual = extension_replace($path, $replacement, $prefix);
        $this->assertEquals($expected, $actual);
    }

    #[TestWith(['\dir\foo.pre.ext', 'next', '', '\\', '\dir\foo.pre.next'])]
    public function testReplacesExtensionWithCustomDirectorySeparator(
        string  $path,
        ?string $replacement,
        string  $prefix,
        string  $directory_separator,
        string  $expected,
    ): void {
        assert(is_non_empty_string($directory_separator));
        $actual = extension_replace($path, $replacement, $prefix, $directory_separator);
        $this->assertEquals($expected, $actual);
    }
}
