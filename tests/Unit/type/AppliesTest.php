<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

namespace empaphy\usephul\tests\Unit\type\AppliesTest;

use Attribute;
use empaphy\usephul\type;
use stdClass;

describe('applies()', function () {
    #[Attribute(Attribute::TARGET_CLASS)]
    class MockAttribute {}

    #[MockAttribute]
    class MockAttributeTarget {}

    class MockAttributeTargetChild extends MockAttributeTarget {}

    test('returns true when attribute is applied to class', function () {
        $applied = type\applies(MockAttributeTarget::class, MockAttribute::class);

        expect($applied)->toBeTrue();
    });

    test('returns false when attribute is not applied to class', function () {
         $applied = type\applies(stdClass::class, MockAttribute::class);

         expect($applied)->toBeFalse();
    });

    test('returns true when attribute is applied to object', function () {
        $object = new MockAttributeTarget();
        $applied = type\applies($object, MockAttribute::class);

        expect($applied)->toBeTrue();
    });

    test('returns false when attribute is not applied to object', function () {
        $object = new stdClass();
        $applied = type\applies($object, MockAttribute::class);

        expect($applied)->toBeFalse();
    });

    test('returns false when attribute is applied to parent', function () {
        $object = new MockAttributeTargetChild();
        $applied = type\applies($object, MockAttribute::class);

        expect($applied)->toBeFalse();
    });
});
