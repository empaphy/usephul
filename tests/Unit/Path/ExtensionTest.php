<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\Path\extension;
use function pathinfo;

use const PATHINFO_EXTENSION;

#[CoversFunction('empaphy\usephul\Path\extension')]
class ExtensionTest extends TestCase
{
    /**
     * @formatter:off
     */
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext', 'expected' => 'ext'])]
    #[TestWith(['path' => '/root/dir/sub/name.suf.',    'expected' => ''])]
    #[TestWith(['path' => '/root/dir/sub/name.ext',     'expected' => 'ext'])]
    #[TestWith(['path' => '/root/dir/sub/name.',        'expected' => ''])]
    #[TestWith(['path' => '/root/dir/sub/name',         'expected' => ''])]
    #[TestWith(['path' => '/root/dir/sub/.ext',         'expected' => 'ext'])]
    #[TestWith(['path' => '/root/dir/sub/.',            'expected' => ''])]
    #[TestWith(['path' => '/root/dir/sub/',             'expected' => ''])]
    public function testReturnsCorrectExtension(string $path, string $expected): void
    {
        $pathinfo = pathinfo($path, PATHINFO_EXTENSION);
        $extension = extension($path);

        $this->assertEquals($pathinfo, $extension);
        $this->assertEquals($expected, $extension);
    }
}
