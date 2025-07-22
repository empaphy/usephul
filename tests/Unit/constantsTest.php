<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\constants;

use empaphy\usephul;

describe('E_EVERYTHING', function () {
    it('is defined', function () {
        expect(defined('empaphy\usephul\E_EVERYTHING'))->toBeTrue();
    });

    it('matches', function ($expected) {
        expect(usephul\E_EVERYTHING)->toBe($expected);
    })->with([[0x7FFFFFFF]]);
});
