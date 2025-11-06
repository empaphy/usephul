<?php

declare(strict_types=1);

dataset('Path / directory_separator', [
    ...require __DIR__ . '/Datasets/directory_separator.php',
]);

dataset('Path / extension_replace', [
    ...require __DIR__ . '/Datasets/extension_replace_defaults.php',
    ...require __DIR__ . '/Datasets/extension_replace_empty_replacement.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_dot_prefix.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_dot_prefix_and_replacement.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_hyphen_prefix_and_replacement.php',
    ...require __DIR__ . '/Datasets/extension_replace_with_replacement.php',
]);

dataset('Path / filename defaults', [
    ...require __DIR__ . '/Datasets/filename_defaults_root.php',
    ...require __DIR__ . '/Datasets/filename_defaults_relative.php',
]);

dataset('Path / filename with suffix', [
    ...require __DIR__ . '/Datasets/filename_suffix_root.php',
    ...require __DIR__ . '/Datasets/filename_suffix_relative.php',
    ...require __DIR__ . '/Datasets/filename_suffix_dir_root.php',
    ...require __DIR__ . '/Datasets/filename_suffix_dir_relative.php',
]);

dataset('Path / suffix', [
    ...require __DIR__ . '/Datasets/suffix.php',
]);
