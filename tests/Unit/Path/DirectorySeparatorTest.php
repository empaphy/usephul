<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesFunction;
use Tests\TestCase;
use ValueError;

use function assert;
use function empaphy\usephul\Path\directory_separator;
use function empaphy\usephul\Var\is_non_empty_string;

#[CoversFunction('empaphy\usephul\Path\directory_separator')]
#[UsesFunction('empaphy\usephul\Var\is_non_empty_string')]
class DirectorySeparatorTest extends TestCase
{
    /**
     * @formatter:off
     */
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext',       'directory_separator' => '/',  'expected' => '/'])]
    #[TestWith(['path' => '/root/dir/sub/name.suf.ext',       'directory_separator' => '\\', 'expected' => '/'])]
    #[TestWith(['path' => 'C:\\root\\dir\\sub\\name.suf.ext', 'directory_separator' => '/',  'expected' => '/'])]
    #[TestWith(['path' => 'C:\\root\\dir\\sub\\name.suf.ext', 'directory_separator' => '\\', 'expected' => '\\'])]
    #[TestWith(['path' => 'C:\\root/dir\\sub/name.suf.ext',   'directory_separator' => '/',  'expected' => '/'])]
    #[TestWith(['path' => 'C:\\root/dir\\sub/name.suf.ext',   'directory_separator' => '\\', 'expected' => '\\'])]
    #[TestWith(['path' => 'name.suf.ext',                     'directory_separator' => '/',  'expected' => '/'])]
    #[TestWith(['path' => 'name.suf.ext',                     'directory_separator' => '\\', 'expected' => '\\'])]
    public function testReturnsCorrectSeparator(string $path, string $directory_separator, string $expected): void
    {
        assert(is_non_empty_string($directory_separator));
        $separator = directory_separator($path, $directory_separator);
        $this->assertEquals($expected, $separator);
    }

    public function testThrowsValueErrorWithEmptyDirectorySeparator(): void
    {
        $this->expectException(ValueError::class);
        directory_separator('/root/dir/sub/name.suf.ext', ''); // @phpstan-ignore argument.type
    }
}
