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

namespace Pest\Unit\Sorting;

use empaphy\usephul\Sorting\Type;

describe('Sorting Type enum', function () {
    test('has correct values', function (Type $sortingType, $value) {
        expect($sortingType->value)->toBe($value);
    })->with([
        'regular'                  => [Type::Regular,                SORT_REGULAR],
        'case insensitive regular' => [Type::RegularCaseInsensitive, SORT_REGULAR | SORT_FLAG_CASE],
        'numeric'                  => [Type::Numeric,                SORT_NUMERIC],
        'string'                   => [Type::String,                 SORT_STRING],
        'case insensitive string'  => [Type::StringCaseInsensitive,  SORT_STRING | SORT_FLAG_CASE],
        'locale string'            => [Type::LocaleString,           SORT_LOCALE_STRING],
        'natural'                  => [Type::Natural,                SORT_NATURAL],
    ]);
});
