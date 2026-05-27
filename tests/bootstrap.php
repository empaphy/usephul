<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;

if (! class_exists(\PHPUnit\Framework\Attributes\CoversTrait::class)) {
    class_alias(CoversClass::class, \PHPUnit\Framework\Attributes\CoversTrait::class);
}
