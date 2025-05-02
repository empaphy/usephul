<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 *
 * @noinspection StaticClosureCanBeUsedInspection
 */

declare(strict_types=1);

use empaphy\usephul;

describe('applies()', function () {
    #[Attribute(Attribute::TARGET_CLASS)]
    class MockAttribute {}

    #[MockAttribute]
    class MockAttributeTarget {}

    class MockAttributeTargetChild extends MockAttributeTarget {}

    test('returns true when attribute is applied to class', function () {
        $applied = usephul\applies(MockAttributeTarget::class, MockAttribute::class);

        expect($applied)->toBeTrue();
    });

    test('returns false when attribute is not applied to class', function () {
         $applied = usephul\applies(stdClass::class, MockAttribute::class);

         expect($applied)->toBeFalse();
    });

    test('returns true when attribute is applied to object', function () {
        $object = new MockAttributeTarget();
        $applied = usephul\applies($object, MockAttribute::class);

        expect($applied)->toBeTrue();
    });

    test('returns false when attribute is not applied to object', function () {
        $object = new stdClass();
        $applied = usephul\applies($object, MockAttribute::class);

        expect($applied)->toBeFalse();
    });

    test('returns false when attribute is applied to parent', function () {
        $object = new MockAttributeTargetChild();
        $applied = usephul\applies($object, MockAttribute::class);

        expect($applied)->toBeFalse();
    });
});
