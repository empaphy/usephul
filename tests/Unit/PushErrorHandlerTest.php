<?php

declare(strict_types=1);

namespace Tests\Unit;

use Closure;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

use function empaphy\usephul\push_error_handler;
use function restore_error_handler;
use function set_error_handler;

use const E_USER_NOTICE;

#[CoversFunction('empaphy\usephul\push_error_handler')]
class PushErrorHandlerTest extends TestCase
{
    public function testSetsErrorHandlerNormallyIfNoHandlerIsSet(): void
    {
        set_error_handler(null, E_USER_NOTICE);
        $pushErrorHandler = self::createErrorHandler(fn(string $message): bool => true);

        push_error_handler($pushErrorHandler);

        $errorHandler = get_error_handler();
        $this->assertSame($pushErrorHandler, $errorHandler);

        restore_error_handler();
        restore_error_handler();
    }

    public function testDelegatesWhenErrorHandlerReturnsFalse(): void
    {
        $nextMessage = null;
        $nextErrorHandler = self::createErrorHandler(
            function (string $message) use (&$nextMessage): bool {
                $nextMessage = $message;
                return true;
            },
        );
        $pushErrorHandler = self::createErrorHandler(fn(string $message): bool => false);

        set_error_handler($nextErrorHandler, E_USER_NOTICE);
        push_error_handler($pushErrorHandler, E_USER_NOTICE);

        $nextMessage = 'bar';

        trigger_error('foo', E_USER_NOTICE);
        $this->assertSame('foo', $nextMessage); // @phpstan-ignore method.impossibleType

        restore_error_handler();
        restore_error_handler();
    }

    public function testDoesntDelegateWhenErrorHandlerReturnsTrue(): void
    {
        $nextMessage = null;
        $nextErrorHandler = self::createErrorHandler(
            function (string $message) use (&$nextMessage): bool {
                $nextMessage = $message;
                return true;
            },
        );
        $pushErrorHandler = self::createErrorHandler(fn(string $message): bool => true);

        set_error_handler($nextErrorHandler, E_USER_NOTICE);
        push_error_handler($pushErrorHandler, E_USER_NOTICE);

        $nextMessage = 'bar';

        trigger_error('foo', E_USER_NOTICE);
        $this->assertSame('bar', $nextMessage); // @phpstan-ignore method.alreadyNarrowedType

        restore_error_handler();
        restore_error_handler();
    }

    /**
     * @template TReturn of bool
     *
     * @param  callable(string $message): TReturn  $callback
     * @return Closure(int, string, ?string, ?int): TReturn
     */
    private static function createErrorHandler(callable $callback): Closure
    {
        return static fn(
            int     $_errno,
            string  $_errstr,
            ?string $_errfile = null,
            ?int    $_errline = null,
        ): bool => $callback($_errstr);
    }
}
