<?php

declare(strict_types=1);

namespace empaphy\usephul\debug\Backtrace;

/**
 * @template TObject
 *
 * @property-read non-empty-string           $file,
 * @property-read positive-int               $line,
 * @property-read string                     $function,
 * @property-read null|class-string<TObject> $class
 * @property-read null|TObject               $object,
 * @property-read null|MethodCallType        $type,
 * @property-read null|array                 $args,
 */
interface Frame {}
