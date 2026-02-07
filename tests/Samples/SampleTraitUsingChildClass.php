<?php

declare(strict_types=1);

namespace Tests\Samples;

class SampleTraitUsingChildClass extends SampleTraitUsingParentClass
{
    use SampleChildTrait;
}
