<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Countable;

class SampleCountable implements Countable
{
    /**
     * @param  non-negative-int  $value
     */
    public function __construct(private readonly int $value = 0) {}

    public function count(): int
    {
        return $this->value;
    }
}
