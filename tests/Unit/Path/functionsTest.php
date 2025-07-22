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

describe('Path', function () {
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
            ['path' => '/root/dir/sub/name.ext', 'returns' => 'ext'],
            ['path' => '/root/dir/sub/name', 'returns' => ''],
            ['path' => '/root/dir/sub/.ext', 'returns' => 'ext'],
            ['path' => '/root/dir/sub/', 'returns' => ''],
        ]);
    });

    describe('extension_replace()', function () {
        test('replaces directory name', function ($path, $replacement, $suffix, $returns) {
            $replaced = Path\extension_replace($path, $replacement, $suffix);

            expect($replaced)->toEqual($returns);
        })->with([
            ['path' => 'dir/name.suf.ext', 'replacement' => 'next', 'suffix' => '', 'returns' => 'dir/name.suf.next'],
            ['path' => 'dir/name.suf.ext', 'replacement' => 'next', 'suffix' => '.suf', 'returns' => 'dir/name.next'],
            ['path' => 'dir/name.suf.ext', 'replacement' => '', 'suffix' => '', 'returns' => 'dir/name.suf'],
            ['path' => 'dir/name.suf.ext', 'replacement' => '', 'suffix' => '.suf', 'returns' => 'dir/name'],
            ['path' => 'dir/name.suf.ext', 'replacement' => '', 'suffix' => '.ext', 'returns' => 'dir/name.suf'],
            ['path' => 'dir/name.suf.ext', 'replacement' => '', 'suffix' => '.bar', 'returns' => 'dir/name.suf'],
        ]);
    });

    describe('filename()', function () {
        test('returns correct filename', function ($path) {
            $pathinfo = pathinfo($path, PATHINFO_FILENAME);
            $filename = Path\filename($path);

            expect($filename)->toEqual($pathinfo);
        })->with([
            ['path' => '/root/dir/sub/name.suf.ext'],
            ['path' => '/root/dir/sub/name.ext'],
            ['path' => '/root/dir/sub/name'],
            ['path' => '/root/dir/sub/.ext'],
            ['path' => '/root/dir/sub/'],
        ]);

        test('returns file name, without suffix', function ($path, $suffix, $expected) {
            $filename = Path\filename($path, $suffix);

            expect($filename)->toEqual($expected);
        })->with([
            ['path' => '/root/dir/sub/name.suf.ext', 'suffix' => '.ext', 'expected' => 'name.suf'],
            ['path' => '/root/dir/sub/name.suf.ext', 'suffix' => '.suf', 'expected' => 'name'],
            ['path' => '/root/dir/sub/name.suf.suf', 'suffix' => '.suf', 'expected' => 'name'],
            ['path' => '/root/dir/sub/name.ext', 'suffix' => '.suf', 'expected' => 'name'],
            ['path' => '/root/dir/sub/name.suf', 'suffix' => '.suf', 'expected' => 'name'],
            ['path' => '/root/dir/sub/name', 'suffix' => '.suf', 'expected' => 'name'],
            ['path' => '/root/dir/sub/.suf.ext', 'suffix' => '.suf', 'expected' => ''],
            ['path' => '/root/dir/sub/', 'suffix' => '.suf', 'expected' => 'sub'],
            ['path' => '/root/dir/sub/', 'suffix' => 'sub', 'expected' => ''],
        ]);
    });
});
