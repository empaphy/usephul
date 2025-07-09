<?php

declare(strict_types=1);

namespace empaphy\usephul\debug\Backtrace;

enum MethodCallType: string
{
    case Instance = '->';
    case Static   = '::';
}
