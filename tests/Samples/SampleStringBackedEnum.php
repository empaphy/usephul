<?php

declare(strict_types=1);

namespace Tests\Samples;

enum SampleStringBackedEnum: string
{
    case Baz = 'baz';
    case Qux = 'qux';
}
