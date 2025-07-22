<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace Pest\Unit\Type\applies;

use Attribute;
use empaphy\usephul\Type;
use stdClass;

describe('applies()', function () {
    #[Attribute(Attribute::TARGET_CLASS)]
    class MockAttribute {}

    #[MockAttribute]
    class MockAttributeTarget {}

    class MockAttributeTargetChild extends MockAttributeTarget {}

    test('returns true when attribute is applied to class', function () {
        $applied = Type\applies(MockAttributeTarget::class, MockAttribute::class);

        expect($applied)->toBeTrue();
    });

    test('returns false when attribute is not applied to class', function () {
        $applied = Type\applies(stdClass::class, MockAttribute::class);

        expect($applied)->toBeFalse();
    });

    test('returns true when attribute is applied to object', function () {
        $object = new MockAttributeTarget();
        $applied = Type\applies($object, MockAttribute::class);

        expect($applied)->toBeTrue();
    });

    test('returns false when attribute is not applied to object', function () {
        $object = new stdClass();
        $applied = Type\applies($object, MockAttribute::class);

        expect($applied)->toBeFalse();
    });

    test('returns false when attribute is applied to parent', function () {
        $object = new MockAttributeTargetChild();
        $applied = Type\applies($object, MockAttribute::class);

        expect($applied)->toBeFalse();
    });
});
