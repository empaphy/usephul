<?php

declare(strict_types=1);

namespace Tests\Unit\Path;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\RequiresOperatingSystemFamily;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function empaphy\usephul\Path\components;

/**
 * @formatter:off
 */
#[CoversFunction('empaphy\usephul\Path\components')]
class ComponentsTest extends TestCase
{
    #[TestWith(['path' => '',                    'expected' => []])]
    #[TestWith(['path' => '.',                   'expected' => ['']])]
    #[TestWith(['path' => '..',                  'expected' => ['..']])]
    #[TestWith(['path' => '../',                 'expected' => ['..']])]
    #[TestWith(['path' => '../bar/baz/qux/ham',  'expected' => ['..', 'bar', 'baz', 'qux', 'ham']])]
    #[TestWith(['path' => './',                  'expected' => ['']])]
    #[TestWith(['path' => './.',                 'expected' => ['']])]
    #[TestWith(['path' => '././',                'expected' => ['']])]
    #[TestWith(['path' => './bar/baz/qux/ham',   'expected' => ['bar', 'baz', 'qux', 'ham']])]
    #[TestWith(['path' => '.foo',                'expected' => ['.foo']])]
    #[TestWith(['path' => '/',                   'expected' => ['']])]
    #[TestWith(['path' => '/..',                 'expected' => ['..']])]
    #[TestWith(['path' => '/./',                 'expected' => ['']])]
    #[TestWith(['path' => '/./.',                'expected' => ['']])]
    #[TestWith(['path' => '/bar/../qux/',        'expected' => ['bar', '..', 'qux']])]
    #[TestWith(['path' => '/bar/./qux/',         'expected' => ['bar', 'qux']])]
    #[TestWith(['path' => '/bar//qux/',          'expected' => ['bar', 'qux']])]
    #[TestWith(['path' => 'foo',                 'expected' => ['foo']])]
    #[TestWith(['path' => 'foo/bar/baz/qux/ham', 'expected' => ['foo', 'bar', 'baz', 'qux', 'ham']])]
    public function testReturnsCorrectComponents(string $path, array $expected): void
    {
        $components = components($path);
        $this->assertEquals($expected, $components);
    }

    #[RequiresOperatingSystemFamily('Windows')]
    #[TestWith(['path' => 'foo\\bar/baz\\qux/ham', 'expected' => ['foo', 'bar', 'baz', 'qux', 'ham']])]
    #[TestWith(['path' => '\\bar/\\qux/',          'expected' => ['bar', 'qux']])]
    #[TestWith(['path' => '/bar\\/qux\\',          'expected' => ['bar', 'qux']])]
    #[TestWith(['path' => '\\',                    'expected' => ['']])]
    #[TestWith(['path' => 'C:\\',                  'expected' => ['']])]
    #[TestWith(['path' => 'C:\\foo',               'expected' => ['foo']])]
    public function testUsesBackslashAsDirectorySeparatorOnWindows(string $path, array $expected): void
    {
        $components = components($path);
        $this->assertEquals($expected, $components);
    }
}
