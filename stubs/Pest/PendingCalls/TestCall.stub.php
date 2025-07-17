<?php

/**
 * @noinspection ALL
 */

declare(strict_types=1);

namespace Pest\PendingCalls;

use Closure;

final class TestCall
{
    /**
     * Runs the given closure after the test.
     */
    public function after(Closure $closure): self {}

    /**
     * Asserts that the test fails with the given message.
     */
    public function fails(?string $message = null): self {}

    /**
     * Asserts that the test throws the given `$exceptionClass` when called.
     */
    public function throws(
        string|int $exception,
        ?string $exceptionMessage = null,
        ?int $exceptionCode = null
    ): self {}

    /**
     * Asserts that the test throws the given `$exceptionClass` when called if
     * the given condition is true.
     *
     * @param  (callable(): bool)|bool  $condition
     */
    public function throwsIf(
        callable|bool $condition,
        string|int $exception,
        ?string $exceptionMessage = null,
        ?int $exceptionCode = null
    ): self {}

    /**
     * Asserts that the test throws the given `$exceptionClass` when called if
     * the given condition is false.
     *
     * @param  (callable(): bool)|bool  $condition
     */
    public function throwsUnless(
        callable|bool $condition,
        string|int $exception,
        ?string $exceptionMessage = null,
        ?int $exceptionCode = null
    ): self {}

    /**
     * Runs the current test multiple times with each item of the given
     * `iterable`.
     *
     * @param  array<\Closure|iterable<int|string, mixed>|string>  $data
     */
    public function with(Closure|iterable|string ...$data): self {}

    /**
     * Sets the test depends.
     */
    public function depends(string ...$depends): self {}

    /**
     * Sets the test group(s).
     */
    public function group(string ...$groups): self {}

    /**
     * Filters the test suite by "only" tests.
     */
    public function only(): self {}

    /**
     * Skips the current test.
     */
    public function skip(
        Closure|bool|string $conditionOrMessage = true,
        string $message = ''
    ): self {}

    /**
     * Skips the current test on the given PHP version.
     */
    public function skipOnPhp(string $version): self {}

    /**
     * Skips the current test if the given test is running on Windows.
     */
    public function skipOnWindows(): self {}

    /**
     * Skips the current test if the given test is running on Mac OS.
     */
    public function skipOnMac(): self {}

    /**
     * Skips the current test if the given test is running on Linux.
     */
    public function skipOnLinux(): self {}

    /**
     * Skips the current test if the given test is running on the given operating systems.
     */
    private function skipOnOs(string $osFamily, string $message): self {}

    /**
     * Skips the current test unless the given test is running on Windows.
     */
    public function onlyOnWindows(): self {}

    /**
     * Skips the current test unless the given test is running on Mac.
     */
    public function onlyOnMac(): self {}

    /**
     * Skips the current test unless the given test is running on Linux.
     */
    public function onlyOnLinux(): self {}

    /**
     * Repeats the current test the given number of times.
     */
    public function repeat(int $times): self {}

    /**
     * Marks the test as "todo".
     *
     * @param  array<mixed>|string|null  $note
     * @param  array<mixed>|string|null  $assignee
     * @param  array<mixed>|string|null  $issue
     * @param  array<mixed>|string|null  $pr
     */
    public function todo(
        array|string|null $note = null,
        array|string|null $assignee = null,
        array|string|int|null $issue = null,
        array|string|int|null $pr = null,
    ): self {}

    /**
     * Sets the test as "work in progress".
     *
     * @param  array<mixed>|string|null  $note
     * @param  array<mixed>|string|null  $assignee
     * @param  array<mixed>|string|null  $issue
     * @param  array<mixed>|string|null  $pr
     */
    public function wip(
        array|string|null $note = null,
        array|string|null $assignee = null,
        array|string|int|null $issue = null,
        array|string|int|null $pr = null,
    ): self {}

    /**
     * Sets the test as "done".
     *
     * @param  array<mixed>|string|null  $note
     * @param  array<mixed>|string|null  $assignee
     * @param  array<mixed>|string|null  $issue
     * @param  array<mixed>|string|null  $pr
     */
    public function done(
        array|string|null $note = null,
        array|string|null $assignee = null,
        array|string|int|null $issue = null,
        array|string|int|null $pr = null,
    ): self {}

    /**
     * Associates the test with the given issue(s).
     *
     * @param  array<int, string|int>|string|int  $number
     */
    public function issue(array|string|int $number): self {}

    /**
     * Associates the test with the given ticket(s). (Alias for `issue`)
     *
     * @param  array<int, string|int>|string|int  $number
     */
    public function ticket(array|string|int $number): self {}

    /**
     * Sets the test assignee(s).
     *
     * @param  array<int, string>|string  $assignee
     */
    public function assignee(array|string $assignee): self {}

    /**
     * Associates the test with the given pull request(s).
     *
     * @param  array<int, string|int>|string|int  $number
     */
    public function pr(array|string|int $number): self {}

    /**
     * Adds a note to the test.
     *
     * @param  array<int, string>|string  $note
     */
    public function note(array|string $note): self {}

    /**
     * Sets the covered classes or methods.
     *
     * @param  array<int, string>|string  $classesOrFunctions
     */
    public function covers(array|string ...$classesOrFunctions): self {}

    /**
     * Sets the covered classes.
     */
    public function coversClass(string ...$classes): self {}

    /**
     * Sets the covered classes.
     */
    public function coversTrait(string ...$traits): self {}

    /**
     * Sets the covered functions.
     */
    public function coversFunction(string ...$functions): self {}

    /**
     * Sets that the current test covers nothing.
     */
    public function coversNothing(): self {}

    /**
     * Informs the test runner that no expectations happen in this test,
     * and its purpose is simply to check whether the given code can
     * be executed without throwing exceptions.
     */
    public function throwsNoExceptions(): self {}

    /**
     * Saves the property accessors to be used on the target.
     */
    public function __get(string $name): self {}

    /**
     * Saves the calls to be used on the target.
     *
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): self {}

    /**
     * Add a chain to the test case factory. Omitting the arguments will treat
     * it as a property accessor.
     *
     * @param  array<int, mixed>|null  $arguments
     */
    private function addChain(
        string $file,
        int $line,
        string $name,
        ?array $arguments = null,
    ): self {}

    /**
     * Creates the Call.
     */
    public function __destruct() {}
}
