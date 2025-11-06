<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection MultipleExpectChainableInspection
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\Path;

use empaphy\usephul\Path;
use ValueError;

use function pathinfo;

use const PATHINFO_FILENAME;

describe('Path', function () {
    describe('components()', function () {
        test('returns correct components', function ($path, $expected) {
            $components = Path\components($path);
            expect($components)->toEqual($expected);
        })->with([
            ['path' => '<cwd1>/<cwd2>//<cwd3>/<name>', 'expected' => ['<cwd1>', '<cwd2>',  null , '<cwd3>', '<name>']],
            ['path' => '////<name>',                   'expected' => [  null  ,   null  ,  null ,   null  , '<name>']],
            ['path' => '<cwd1>/<cwd2>//<cwd3>/',       'expected' => ['<cwd1>', '<cwd2>',  null , '<cwd3>',   null  ]],
            ['path' => '////',                         'expected' => [  null  ,   null  ,  null ,   null  ,   null  ]],
            ['path' => '/',                            'expected' => [  null  ,   null                              ]],
            ['path' => '',                             'expected' => [  null                                        ]],
            ['path' => '0',                            'expected' => [  '0'                                         ]],
            ['path' => 'false',                        'expected' => ['false'                                         ]],
            ['path' => '%2Fetc/motd',                  'expected' => ['%2Fetc',  'motd'                             ]],
            ['path' => 'etc/motd',                     'expected' => [ 'etc'  ,  'motd'                             ]],
            ['path' => '/etc/motd',                    'expected' => [  null  ,   'etc' , 'motd'                    ]],
            ['path' => 'motd',                         'expected' => [ 'motd'                                       ]],
        ]);
    });

    describe('directory_separator()', function () {
        test('returns correct directory separator', function ($path, $DIRECTORY_SEPARATOR, $expected) {
            $separator = Path\directory_separator($path, $DIRECTORY_SEPARATOR);
            expect($separator)->toEqual($expected);
        })->with('Path / directory_separator');
    });

    describe('dirname()', function () {
        test('returns correct directory name', function ($path, $returns) {
            $pathinfo = pathinfo($path, PATHINFO_DIRNAME);
            $expected = dirname($path);
            $dirname = Path\dirname($path);

            expect($expected)->toEqual($returns)->and($pathinfo)->toEqual($expected);
            expect($pathinfo)->toEqual($returns);
            expect($dirname)->toEqual($expected);
            expect($dirname)->toEqual($returns);
            expect($dirname)->toEqual($pathinfo);
        })->with([
            ['path' => '/root/dir/sub/name.suf.ext', 'returns' => '/root/dir/sub'],
            ['path' => '/root/dir/sub/name.ext', 'returns' => '/root/dir/sub'],
            ['path' => '/root/dir/sub/name', 'returns' => '/root/dir/sub'],
            ['path' => '/root/dir/sub/.ext', 'returns' => '/root/dir/sub'],
            ['path' => '/root/dir/sub/', 'returns' => '/root/dir'],
            ['path' => '/root/dir/sub', 'returns' => '/root/dir'],
            ['path' => 'dir/sub/name.suf.ext', 'returns' => 'dir/sub'],
            ['path' => 'dir/sub/name.ext', 'returns' => 'dir/sub'],
            ['path' => 'dir/sub/name', 'returns' => 'dir/sub'],
            ['path' => 'dir/sub/.ext', 'returns' => 'dir/sub'],
            ['path' => 'dir/sub/', 'returns' => 'dir'],
            ['path' => 'dir/sub', 'returns' => 'dir'],
            ['path' => 'sub/name.suf.ext', 'returns' => 'sub'],
            ['path' => 'sub/name.ext', 'returns' => 'sub'],
            ['path' => 'sub/name', 'returns' => 'sub'],
            ['path' => 'sub/.ext', 'returns' => 'sub'],
            ['path' => 'sub/', 'returns' => '.'],
            ['path' => 'sub', 'returns' => '.'],
            ['path' => 'name.suf.ext', 'returns' => '.'],
            ['path' => 'name.ext', 'returns' => '.'],
            ['path' => 'name', 'returns' => '.'],
            ['path' => '.ext', 'returns' => '.'],
            ['path' => '', 'returns' => ''],
        ]);

        test('returns correct directory name, with levels', function ($path, $levels, $returns) {
            $expected = dirname($path, $levels);
            $dirname = Path\dirname($path, $levels);

            expect($returns)->toEqual($expected);
            expect($dirname)->toEqual($expected);
        })->with([
            ['path' => '/root/dir/sub/name.suf.ext', 'levels' => 4, 'returns' => '/'],
            ['path' => '/root/dir/sub/name.suf.ext', 'levels' => 3, 'returns' => '/root'],
            ['path' => '/root/dir/sub/name.suf.ext', 'levels' => 2, 'returns' => '/root/dir'],
            ['path' => '/root/dir/sub/', 'levels' => 2, 'returns' => '/root'],
            ['path' => '/root/dir/sub', 'levels' => 2, 'returns' => '/root'],
            ['path' => 'dir/sub/name.suf.ext', 'levels' => 2, 'returns' => 'dir'],
            ['path' => 'dir/sub/', 'levels' => 2, 'returns' => '.'],
            ['path' => 'dir/sub', 'levels' => 2, 'returns' => '.'],
            ['path' => 'sub/name.suf.ext', 'levels' => 2, 'returns' => '.'],
        ]);
    });

    describe('extension()', function () {
        test('returns correct extension', function ($path, $returns) {
            $pathinfo = pathinfo($path, PATHINFO_EXTENSION);
            $extension = Path\extension($path);

            expect($pathinfo)->toEqual($returns);
            expect($extension)->toEqual($returns);
            expect($extension)->toEqual($pathinfo);
        })->with([
            ['path' => '/root/dir/sub/name.suf.ext', 'returns' => 'ext'],
            ['path' => '/root/dir/sub/name.suf.', 'returns' => ''],
            ['path' => '/root/dir/sub/name.ext', 'returns' => 'ext'],
            ['path' => '/root/dir/sub/name.', 'returns' => ''],
            ['path' => '/root/dir/sub/name', 'returns' => ''],
            ['path' => '/root/dir/sub/.ext', 'returns' => 'ext'],
            ['path' => '/root/dir/sub/.', 'returns' => ''],
            ['path' => '/root/dir/sub/', 'returns' => ''],
        ]);
    });

    describe('extension_replace', function () {
        test('replaces extension', function ($path, $replacement, $prefix, $expected) {
            $replaced = Path\extension_replace($path, $replacement, $prefix);

            expect($replaced)->toEqual($expected);
        })->with('Path / extension_replace');
    });

    describe('filename()', function () {
        test('behaves like pathinfo()', function ($path) {
            $expected = pathinfo($path, PATHINFO_FILENAME);
            $filename = Path\filename($path);

            expect($filename)->toEqual($expected);
        })->with('Path / filename defaults');

        test('returns file name, without suffix', function ($path, $suffix, $expected) {
            $filename = Path\filename($path, $suffix);

            expect($filename)->toEqual($expected);
        })->with('Path / filename with suffix');
    });

    describe('suffix()', function () {
        test('uses hyphen as default separator', function () {
            $suffix = Path\suffix('foo-suf.ext');
            expect($suffix)->toEqual('-suf');
        });

        test('returns suffix', function ($path, $separators, $expected) {
            $suffix = Path\suffix($path, ...$separators);
            expect($suffix)->toEqual($expected);
        })->with('Path / suffix');

        describe('throws ValueError for empty separators', function () {
            test('with empty $separator', function () {
                Path\suffix('foo-suf.ext', '');
            })->throws(ValueError::class, 'Argument #2 ($separator) must not be empty');

            test('with variable arguments', function () {
                Path\suffix('foo-suf.ext', '-', '');
            })->throws(ValueError::class, 'Argument #3 (...$separators[0]) must not be empty');

            test('with named arguments', function () {
                Path\suffix('foo-suf.ext', '-', foo: '');
            })->throws(ValueError::class, 'Argument #3 (...$separators[\'foo\']) must not be empty');
        });
    });

    describe('suffix_replace()', function () {
        test('replaces suffix in path', function ($path, $suffix, $separators, $expected) {
            $actual = Path\suffix_replace($path, $suffix, ...$separators);
            expect($actual)->toEqual($expected);
        })->with('Path / suffix_replace');

        describe('throws ValueError', function () {
            test('with empty $separator', function () {
                Path\suffix_replace('foo-suf.ext', '-fix', '');
            })->throws(ValueError::class, 'Argument #3 (...$separators[0]) must not be empty');

            test('with variable arguments', function () {
                Path\suffix_replace('foo-suf.ext', '-fix', '-', '');
            })->throws(ValueError::class, 'Argument #4 (...$separators[1]) must not be empty');

            test('with named arguments', function () {
                Path\suffix_replace('foo-suf.ext', '-fix', '-', foo: '');
            })->throws(ValueError::class, 'Argument #4 (...$separators[\'foo\']) must not be empty');
        });
    });
});
