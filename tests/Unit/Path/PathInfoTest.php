<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul\Path\PathInfo;

describe('PathInfo', function() {
    test('matches pathinfo()', function ($path) {
        $pathInfo = new PathInfo($path);
        $pathinfo = pathinfo($path);

        expect($pathInfo->path)->toEqual($path)
            ->and($pathInfo->dirname)->toEqual($pathinfo['dirname'] ?? null)
            ->and($pathInfo->basename)->toEqual($pathinfo['basename'] ?? null)
            ->and($pathInfo->extension)->toEqual($pathinfo['extension'] ?? null)
            ->and($pathInfo->filename)->toEqual($pathinfo['filename'] ?? null);
    })->with([
        [__FILE__],
        [__DIR__],
        ['foo'],
        ['.'],
        ['..'],
        [''],
    ]);
});
