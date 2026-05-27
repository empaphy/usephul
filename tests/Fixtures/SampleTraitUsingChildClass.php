<?php

declare(strict_types=1);

namespace Tests\Fixtures;

class SampleTraitUsingChildClass extends SampleTraitUsingParentClass
{
    use SampleChildTrait;
}
