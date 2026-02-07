<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\TestCase;

use function assert;
use function empaphy\usephul\Path\dirname;
use function empaphy\usephul\Var\is_positive_int;
use function pathinfo;

#[CoversFunction('empaphy\usephul\Path\dirname')]
#[UsesFunction('empaphy\usephul\Var\is_positive_int')]
class DirnameTest extends TestCase
{
    /**
     * @formatter:off
     */
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext', 'expected' => '/root/dir/sub'])]
    #[TestWith(['path' => '/root/dir/sub/name.ext',     'expected' => '/root/dir/sub'])]
    #[TestWith(['path' => '/root/dir/sub/name',         'expected' => '/root/dir/sub'])]
    #[TestWith(['path' => '/root/dir/sub/.ext',         'expected' => '/root/dir/sub'])]
    #[TestWith(['path' => '/root/dir/sub/',             'expected' => '/root/dir'])]
    #[TestWith(['path' => '/root/dir/sub',              'expected' => '/root/dir'])]
    #[TestWith(['path' => 'dir/sub/name.suf.ext',       'expected' => 'dir/sub'])]
    #[TestWith(['path' => 'dir/sub/name.ext',           'expected' => 'dir/sub'])]
    #[TestWith(['path' => 'dir/sub/name',               'expected' => 'dir/sub'])]
    #[TestWith(['path' => 'dir/sub/.ext',               'expected' => 'dir/sub'])]
    #[TestWith(['path' => 'dir/sub/',                   'expected' => 'dir'])]
    #[TestWith(['path' => 'dir/sub',                    'expected' => 'dir'])]
    #[TestWith(['path' => 'sub/name.suf.ext',           'expected' => 'sub'])]
    #[TestWith(['path' => 'sub/name.ext',               'expected' => 'sub'])]
    #[TestWith(['path' => 'sub/name',                   'expected' => 'sub'])]
    #[TestWith(['path' => 'sub/.ext',                   'expected' => 'sub'])]
    #[TestWith(['path' => 'sub/',                       'expected' => '.'])]
    #[TestWith(['path' => 'sub',                        'expected' => '.'])]
    #[TestWith(['path' => 'name.suf.ext',               'expected' => '.'])]
    #[TestWith(['path' => 'name.ext',                   'expected' => '.'])]
    #[TestWith(['path' => 'name',                       'expected' => '.'])]
    #[TestWith(['path' => '.ext',                       'expected' => '.'])]
    #[TestWith(['path' => '',                           'expected' => ''])]
    public function testReturnsCorrectDirectoryName(string $path, string $expected): void
    {
        $pathinfo = pathinfo($path, PATHINFO_DIRNAME);
        $dirname = \dirname($path);
        $actual = dirname($path);

        $this->assertEquals($pathinfo, $actual);
        $this->assertEquals($dirname, $actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @formatter:off
     */
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext', 'levels' => 4, 'expected' => '/'])]
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext', 'levels' => 3, 'expected' => '/root'])]
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext', 'levels' => 2, 'expected' => '/root/dir'])]
    #[TestWith(['path' => '/root/dir/sub/',             'levels' => 2, 'expected' => '/root'])]
    #[TestWith(['path' => '/root/dir/sub',              'levels' => 2, 'expected' => '/root'])]
    #[TestWith(['path' => 'dir/sub/name.suf.ext',       'levels' => 2, 'expected' => 'dir'])]
    #[TestWith(['path' => 'dir/sub/',                   'levels' => 2, 'expected' => '.'])]
    #[TestWith(['path' => 'dir/sub',                    'levels' => 2, 'expected' => '.'])]
    #[TestWith(['path' => 'sub/name.suf.ext',           'levels' => 2, 'expected' => '.'])]
    public function testReturnsCorrectDirectoryNameWithLevels(string $path, int $levels, string $expected): void
    {
        assert(is_positive_int($levels));
        $dirname = \dirname($path, $levels);
        $actual = dirname($path, $levels);

        $this->assertEquals($dirname, $actual);
        $this->assertEquals($expected, $actual);
    }
}
