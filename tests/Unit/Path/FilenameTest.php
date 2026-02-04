<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;

use function empaphy\usephul\Path\filename;
use function pathinfo;

#[CoversFunction('empaphy\usephul\Path\filename')]
class FilenameTest extends TestCase
{
    #[DataProviderExternal(Datasets\FilenameDefaultsRoot::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\FilenameDefaultsRelative::class, 'dataProvider')]
    public function testBehavesLikePathinfo(string $path): void
    {
        $expected = pathinfo($path, PATHINFO_FILENAME);
        $filename = filename($path);
        $this->assertEquals($expected, $filename);
    }

    #[DataProviderExternal(Datasets\FilenameSuffixRoot::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\FilenameSuffixRelative::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\FilenameSuffixDirRoot::class, 'dataProvider')]
    #[DataProviderExternal(Datasets\FilenameSuffixDirRelative::class, 'dataProvider')]
    public function testReturnsFileNameWithoutSuffix(string $path, string $suffix, string $expected): void
    {
        $filename = filename($path, $suffix);
        $this->assertEquals($expected, $filename);
    }
}
