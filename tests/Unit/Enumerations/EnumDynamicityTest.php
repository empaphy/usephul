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

namespace Pest\Unit\Enumerations;

use empaphy\usephul\Enumerations\EnumDynamicity;

describe('Enumerations', function () {
    describe('EnumDynamicity::try()', function () {
        enum MockEnum: string
        {
            use EnumDynamicity;

            case Foo = 'foo';
            case Bar = 'bar';
        }

        test('returns enum case for provided name', function (MockEnum $mock) {
            $case = MockEnum::try($mock->name);

            expect($case)->toBe($mock);
        })->with([
            ['mock' => MockEnum::Foo],
            ['mock' => MockEnum::Bar],
        ]);

        test('returns `null` if a provided name does not exist', function () {
            $case = MockEnum::try('Baz');

            expect($case)->toBeNull();
        });

        test('throws a `ValueError` when provided an empty string', function () {
            MockEnum::try(''); // @phpstan-ignore argument.type
        })->throws(\ValueError::class);
    });
});
