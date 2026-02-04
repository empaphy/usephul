<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use empaphy\usephul\Path\PathInfo;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

#[CoversClass(PathInfo::class)]
class PathInfoTest extends TestCase
{
    #[TestWith([__FILE__])]
    #[TestWith([__DIR__])]
    #[TestWith(['foo'])]
    #[TestWith(['.'])]
    #[TestWith(['..'])]
    #[TestWith([''])]
    public function testMatchesPathinfo(string $path): void
    {
        $pathInfo = new PathInfo($path);
        $pathinfo = pathinfo($path);

        $this->assertEquals($path, $pathInfo->path);
        $this->assertEquals($pathinfo['dirname'] ?? null, $pathInfo->dirname);
        $this->assertEquals($pathinfo['basename'] ?? null, $pathInfo->basename);
        $this->assertEquals($pathinfo['extension'] ?? null, $pathInfo->extension);
        $this->assertEquals($pathinfo['filename'] ?? null, $pathInfo->filename);
    }
}
