<?php

declare(strict_types=1);

namespace Tests\Unit\Enumerations\EnumDynamicity;

use empaphy\usephul\Enumerations\EnumDynamicity;

enum SampleDynamicEnum: string
{
    use EnumDynamicity;

    case Foo = 'foo';
    case Bar = 'bar';
}
