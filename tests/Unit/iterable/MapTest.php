<?php

declare(strict_types=1);

namespace empaphy\usephul\tests\Unit\iterable;

use empaphy\usephul\iterable\ArrayMap;

describe('Map::list()', function() {
    test('destructures list array', function() {
        $map = new ArrayMap(['FOO', 'BAR']);

        $map->list($foo, $bar);

        expect($foo)->toBe('FOO')
            ->and($bar)->toBe('BAR');
    });

    test('destructures associative array', function() {
        $map = new ArrayMap(['foo' => 'FOO', 'bar' => 'BAR']);

        $map->list(foo: $foo, bar: $bar);

        expect($foo)->toBe('FOO')
            ->and($bar)->toBe('BAR');
    });
});
