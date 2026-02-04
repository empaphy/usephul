<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\Path\basename;

#[CoversFunction('empaphy\usephul\Path\basename')]
class BasenameTest extends TestCase
{
    #[TestWith(['/foo/bar/baz.txt'])]
    public function testBasenameMatchesBultin(string $path): void
    {
        $expected = \basename($path);
        $actual = basename($path);
        $this->assertEquals($expected, $actual);
    }
}
