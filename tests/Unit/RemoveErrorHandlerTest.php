<?php

declare(strict_types=1);

namespace Tests\Unit;

use Closure;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use Tests\TestCase;

use function empaphy\usephul\remove_error_handler;
use function get_error_handler;
use function restore_error_handler;
use function set_error_handler;

#[CoversFunction('empaphy\usephul\remove_error_handler')]
class RemoveErrorHandlerTest extends TestCase
{
    #[RunInSeparateProcess]
    public function testRemovesCurrentErrorHandler(): void
    {
        $handler = self::createErrorHandler();
        $previousHandler = set_error_handler($handler);

        try {
            $removed = remove_error_handler($handler);

            $this->assertTrue($removed);
            $this->assertSame($previousHandler, get_error_handler());
        } finally {
            self::restoreErrorHandlerStackTo($previousHandler);
        }
    }

    #[RunInSeparateProcess]
    public function testRemovesHandlerBelowCurrentHandlerAndPreservesCurrentHandler(): void
    {
        $removedHandler = self::createErrorHandler();
        $preservedHandler = self::createErrorHandler();
        $previousHandler = set_error_handler($removedHandler);
        set_error_handler($preservedHandler);

        try {
            $removed = remove_error_handler($removedHandler);

            $this->assertTrue($removed);
            $this->assertSame($preservedHandler, get_error_handler());
        } finally {
            self::restoreErrorHandlerStackTo($previousHandler);
        }
    }

    #[RunInSeparateProcess]
    public function testRemovesHandlerBelowDefaultHandlerAndPreservesCurrentHandler(): void
    {
        $removedHandler = self::createErrorHandler();
        $preservedHandler = self::createErrorHandler();
        $previousHandler = set_error_handler(null);

        set_error_handler($preservedHandler);
        set_error_handler(null);
        set_error_handler($removedHandler);
        set_error_handler(null);
        set_error_handler($preservedHandler);

        try {
            $removed = remove_error_handler($removedHandler);

            $this->assertTrue($removed);
            $this->assertSame($preservedHandler, get_error_handler());
            restore_error_handler();
            $this->assertNull(get_error_handler());
            restore_error_handler();
            $this->assertNull(get_error_handler());
            restore_error_handler();
            $this->assertSame($preservedHandler, get_error_handler());
        } finally {
            self::restoreErrorHandlerStackTo($previousHandler);
        }
    }

    #[RunInSeparateProcess]
    public function testRemovesSingleInstanceOfHandler(): void
    {
        $removedHandler = self::createErrorHandler();
        $previousHandler = set_error_handler(null);

        set_error_handler($removedHandler);
        set_error_handler(null);
        set_error_handler($removedHandler);
        set_error_handler(null);

        try {
            $removed = remove_error_handler($removedHandler);

            $this->assertTrue($removed);
            $this->assertNull(get_error_handler());
            restore_error_handler();
            $this->assertNull(get_error_handler());
            restore_error_handler();
            $this->assertSame($removedHandler, get_error_handler());
            restore_error_handler();
            $this->assertNull(get_error_handler());
            restore_error_handler();
            $this->assertSame($previousHandler, get_error_handler());
            restore_error_handler();
        } finally {
            self::restoreErrorHandlerStackTo($previousHandler);
        }
    }

    #[RunInSeparateProcess]
    public function testReturnsFalseWhenHandlerIsNotRegistered(): void
    {
        $registeredHandler = self::createErrorHandler();
        $missingHandler = self::createErrorHandler();
        $previousHandler = set_error_handler($registeredHandler);

        try {
            $removed = remove_error_handler($missingHandler);

            $this->assertFalse($removed);
            $this->assertSame($registeredHandler, get_error_handler());
        } finally {
            self::restoreErrorHandlerStackTo($previousHandler);
        }
    }

    /**
     * @return Closure(int, string, ?string, ?int): bool
     */
    private static function createErrorHandler(): Closure
    {
        return static fn(
            int     $_errno,
            string  $_errstr,
            ?string $_errfile = null,
            ?int    $_errline = null,
        ): bool => true;
    }

    private static function restoreErrorHandlerStackTo(?callable $previousHandler): void
    {
        for ($i = 0; $i < 10 && get_error_handler() !== $previousHandler; $i++) {
            restore_error_handler();
        }
    }
}
