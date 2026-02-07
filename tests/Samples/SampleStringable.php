<?php

declare(strict_types=1);

namespace Tests\Samples;

use Stringable;

class SampleStringable implements Stringable
{
    public function __construct(private readonly string $value) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
