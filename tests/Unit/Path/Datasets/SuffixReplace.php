<?php

declare(strict_types=1);

namespace Tests\Unit\Path\Datasets;

final class SuffixReplace
{
    public static function dataProvider(): array
    {
        return [ //@formatter:off
            ['path' => 'name.ext',      'suffix' => '-fix', 'separators' => [],               'expected' => 'name-fix.ext'],
            ['path' => 'name.ext',      'suffix' => '-fix', 'separators' => ['----'],         'expected' => 'name.ext'],
            ['path' => '/dir/name-suf', 'suffix' => '-fix', 'separators' => ['----', '-'],    'expected' => '/dir/name-fix'],
            ['path' => '.',             'suffix' => '-fix', 'separators' => ['----', '----'], 'expected' => '.'],
            ['path' => './name-suf',    'suffix' => '-fix', 'separators' => ['-suf', '----'], 'expected' => './name-fix'],
            ['path' => 'name-foo-suf',  'suffix' => '-fix', 'separators' => ['-suf', '-foo'], 'expected' => 'name-foo-fix'],
            ['path' => 'name-foo-suf',  'suffix' => '-fix', 'separators' => ['-foo', '-suf'], 'expected' => 'name-foo-fix'],
        ]; //@formatter:on
    }
}

