<?php

declare(strict_types=1);

dataset('Path / extension_replace', [
    ...require __DIR__ . '/Datasets/extension_replace_defaults.php',
    ...require __DIR__ . '/Datasets/extension_replace_empty_replacement.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_dot_prefix.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_dot_prefix_and_replacement.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_hyphen_prefix_and_replacement.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_replacement.php',
]);
