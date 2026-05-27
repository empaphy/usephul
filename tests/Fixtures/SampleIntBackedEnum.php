<?php

declare(strict_types=1);

namespace Tests\Fixtures;

enum SampleIntBackedEnum: int
{
    case Foo = 0xF00;
    case Bar = 0xBA7;
}
