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

namespace Pest\Unit\constants;

use empaphy\usephul\Fallback;

use function constant;
use function defined;

describe('constant', function () {
    it('is defined', function (string $constant_name, $expected) {
        expect(defined($constant_name))->toBeTrue();
        expect(constant($constant_name))->toBe($expected);
    })->with([
        ['empaphy\usephul\E_EVERYTHING', 0x7FFFFFFF],
        ['empaphy\usephul\fallback', Fallback::default],
    ]);
});
