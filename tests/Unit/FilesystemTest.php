<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\tests\Unit\filesystem;

use empaphy\usephul;

describe('filename()', function () {
    test('returns file name', function ($pathComponents) {
        $path = \implode(DIRECTORY_SEPARATOR, $pathComponents);
        $pathinfo = \pathinfo($path, PATHINFO_FILENAME);
        $filename = usephul\filename($path);

        expect($filename)->toEqual($pathinfo);
    })->with([
        [['foo', 'bar.ext']],
    ]);

    test('returns file name, stripping suffix', function ($pathComponents, $suffix, $expected) {
        $path = \implode(DIRECTORY_SEPARATOR, $pathComponents);
        $filename = usephul\filename($path, $suffix);

        expect($filename)->toEqual($expected);
    })->with([
        [['foo', 'bar.ext'], '-suffix', 'bar'],
    ]);
});

describe('extension()', function () {
    test('returns extension', function ($pathComponents) {
        $path = \implode(DIRECTORY_SEPARATOR, $pathComponents);
        $pathinfo = \pathinfo($path, PATHINFO_EXTENSION);
        $extension = usephul\extension($path);

        expect($extension)->toEqual($pathinfo);
    })->with([
        [['foo', 'bar.ext']],
        [['bar.ext']],
        [['bar']],
    ]);
});
