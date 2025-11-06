<?php

declare(strict_types=1);

return [
    ['path' => 'name.ext',      'suffix' => '-fix', 'separators' => ['----'],         'expected' => 'name.ext'],
    ['path' => '/dir/name-suf', 'suffix' => '-fix', 'separators' => ['----', '-'],    'expected' => '/dir/name-fix'],
    ['path' => '.',             'suffix' => '-fix', 'separators' => ['----', '----'], 'expected' => '.'],
    ['path' => './name-suf',    'suffix' => '-fix', 'separators' => ['-suf', '----'], 'expected' => './name-fix'],
    ['path' => 'name-foo-suf',  'suffix' => '-fix', 'separators' => ['-suf', '-foo'], 'expected' => 'name-foo-fix'],
    ['path' => 'name-foo-suf',  'suffix' => '-fix', 'separators' => ['-foo', '-suf'], 'expected' => 'name-foo-fix'],
];
