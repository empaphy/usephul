<?php

declare(strict_types=1);

namespace Tests;

use function assert;
use function restore_error_handler;
use function set_error_handler;

use const E_WARNING;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * A list of warnings that were expected or unexpected.
     *
     * @var array<string, int>
     */
    private array $warnings = [];

    /**
     * Keeps track of how many times the error handler has been set.
     *
     * @var non-negative-int
     */
    private int $errorHandlerSet = 0;

    /**
     * @var ?callable(int $errno, string $errstr, ?string $errfile, ?int $errline): bool
     */
    private mixed $prevHandler = null;

    public function expectWarning(
        string $message,
    ): void {
        $this->warnings[$message] ??= 0;
        $this->warnings[$message]++;

        if ($this->errorHandlerSet === 0) {
            $this->prevHandler = set_error_handler([$this, 'handleWarning'], E_WARNING);
        }

        $this->errorHandlerSet++;
    }

    public function handleWarning(
        int     $errno,
        string  $errstr,
        ?string $errfile = null,
        ?int    $errline = null,
    ): bool {
        assert($errno === E_WARNING);

        if ($this->errorHandlerSet > 0) {
            $this->errorHandlerSet--;
        }

        if ($this->errorHandlerSet === 0) {
            restore_error_handler();
            $this->prevHandler = null;
        }

        $this->warnings[$errstr] ??= 0;
        $this->warnings[$errstr]--;

        if ($this->warnings[$errstr] >= 0) {
            return true;
        }

        return $this->prevHandler
            ? ($this->prevHandler)($errno, $errstr, $errfile, $errline)
            : false;
    }

    protected function tearDown(): void
    {
        if ($this->errorHandlerSet > 0) {
            restore_error_handler();
            $this->errorHandlerSet = 0;
        }

        foreach ($this->warnings as $errstr => $expectedCount) {
            if ($expectedCount > 0) {
                $this->fail("Expected warning was not triggered: $errstr");
            } elseif ($expectedCount < 0) {
                $this->fail("An unexpected warning was triggered: $errstr");
            }
        }

        parent::tearDown();
    }
}
