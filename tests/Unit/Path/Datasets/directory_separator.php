<?php

declare(strict_types=1);

return [
    ['path' => '/root/dir/sub/name.suf.ext',       'DIRECTORY_SEPARATOR' => '/',  'expected' => '/'],
    ['path' => '/root/dir/sub/name.suf.ext',       'DIRECTORY_SEPARATOR' => '\\', 'expected' => '/'],
    ['path' => 'C:\\root\\dir\\sub\\name.suf.ext', 'DIRECTORY_SEPARATOR' => '/',  'expected' => '/'],
    ['path' => 'C:\\root\\dir\\sub\\name.suf.ext', 'DIRECTORY_SEPARATOR' => '\\', 'expected' => '\\'],
    ['path' => 'C:\\root/dir\\sub/name.suf.ext',   'DIRECTORY_SEPARATOR' => '/',  'expected' => '/'],
    ['path' => 'C:\\root/dir\\sub/name.suf.ext',   'DIRECTORY_SEPARATOR' => '\\', 'expected' => '\\'],
    ['path' => 'name.suf.ext',                     'DIRECTORY_SEPARATOR' => '/',  'expected' => '/'],
    ['path' => 'name.suf.ext',                     'DIRECTORY_SEPARATOR' => '\\', 'expected' => '\\'],
];
