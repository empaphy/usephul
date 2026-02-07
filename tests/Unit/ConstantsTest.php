<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use Tests\TestCase;

#[CoversNothing]
class ConstantsTest extends TestCase
{
    #[RunInSeparateProcess]
    public function testIsDefined(): void
    {
        $this->assertTrue(defined('empaphy\usephul\E_EVERYTHING'));
        $this->assertTrue(defined('empaphy\usephul\fallback'));
    }
}
