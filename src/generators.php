<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Generators
 */

declare(strict_types=1);

namespace empaphy\usephul\generators;

use empaphy\usephul\var\Type;
use Generator;
use RangeException;

use function strlen;

/**
 * Sequences a value into a Generator.
 *
 * @param  mixed  $value  The value to sequence.
 * @return Generator<string|int>
 */
function seq(mixed $value): Generator
{
    switch (Type::of($value)) {
        case Type::Boolean:
            yield $value;
            break;

        case Type::ClosedResource:
        case Type::Null:
            yield null;
            break;

        case Type::Integer:
            $value = (string) $value;
            $size = strlen($value);
            for ($i = 0; $i < $size; $i++) {
                yield (int) $value[$i];
            }
            break;

        case Type::Float:
            // I'm not sure how to sequence floats yet, so I'm simply not
            // supporting them for now.
            throw new RangeException('Sequencing floats is not supported.');

        case Type::String:
            $size = strlen($value);
            for ($i = 0; $i < $size; $i++) {
                yield $value[$i];
            }
            break;

        case Type::Object:
        case Type::Array:
        case Type::Unknown:
            foreach ($value as $key => $item) {
                yield $key => $item;
            }
            break;

        case Type::Resource:
            // I'm not sure how to sequence resources yet, so I'm simply not
            // supporting them for now.
            throw new RangeException('Sequencing resources is not supported.');
    }
}
