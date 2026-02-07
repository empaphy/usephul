<?php

declare(strict_types=1);

namespace Tests\Samples;

enum SampleIntBackedEnum: int
{
    case Foo = 0xF00;
    case Bar = 0xBA7;
}
