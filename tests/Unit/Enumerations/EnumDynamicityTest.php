<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   empaphy\rephine
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\rephine\Enumerations\EnumDynamicity;


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
    })->with(MockEnum::cases());

    test('returns `null` if a provided name does not exist', function () {
        $case = MockEnum::try('Baz');

        expect($case)->toBeNull();
    });

    test('throws a `ValueError` when provided an empty string', function () {
        MockEnum::try('');
    })->throws(\ValueError::class);
});
