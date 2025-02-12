<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\usephul
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

describe('E_EVERYTHING', function () {
    it('is defined', function () {
        expect(defined('empaphy\usephul\E_EVERYTHING'))->toBeTrue();
    });

    it('matches', function ($expected) {
        expect(empaphy\usephul\E_EVERYTHING)->toBe($expected);
    })->with([0x7FFFFFFF]);
});
