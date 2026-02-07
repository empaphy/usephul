<?php

declare(strict_types=1);

namespace Tests\Unit\Path\Datasets;

final class FilenameSuffixDirRelative
{
    public static function dataProvider(): array
    {
        return [ //@formatter:off
            ['path' => 'dir-ffs/',             'suffix' => '-ffs', 'expected' => 'dir'],
            ['path' => 'dir./',                'suffix' => '----', 'expected' => 'dir'],
            ['path' => 'dir./.',               'suffix' => '----', 'expected' => ''],
            ['path' => 'dir.ext',              'suffix' => '----', 'expected' => 'dir'],
            ['path' => 'dir.ext/',             'suffix' => '----', 'expected' => 'dir'],
            ['path' => 'dir/',                 'suffix' => '----', 'expected' => 'dir'],
            ['path' => 'dir/-ffu',             'suffix' => '-ffu', 'expected' => ''],
            ['path' => 'dir/-ffx.ext',         'suffix' => '-ffx', 'expected' => ''],
            ['path' => 'dir/-fix/',            'suffix' => '-fix', 'expected' => ''],
            ['path' => 'dir/.',                'suffix' => '----', 'expected' => ''],
            ['path' => 'dir/.-fus',            'suffix' => '-fus', 'expected' => ''],
            ['path' => 'dir/.fux',             'suffix' => '.fux', 'expected' => ''],
            ['path' => 'dir/name',             'suffix' => '----', 'expected' => 'name'],
            ['path' => 'dir/name-fxs',         'suffix' => '-fxs', 'expected' => 'name'],
            ['path' => 'dir/name-sff.',        'suffix' => '-sff', 'expected' => 'name'],
            ['path' => 'dir/name-sfu.ext',     'suffix' => '-sfu', 'expected' => 'name'],
            ['path' => 'dir/name-sfx_foo.ext', 'suffix' => '-sfx', 'expected' => 'name-sfx_foo'],
            ['path' => 'dir/name.',            'suffix' => '----', 'expected' => 'name'],
            ['path' => 'dir/name.-six',        'suffix' => '-six', 'expected' => 'name'],
            ['path' => 'dir/name.-suf.',       'suffix' => '-suf', 'expected' => 'name.'],
            ['path' => 'dir/name.-sux.-sux',   'suffix' => '-sux', 'expected' => 'name.'],
            ['path' => 'dir/name.ext',         'suffix' => '----', 'expected' => 'name'],
            ['path' => 'dir/name.ffu',         'suffix' => '.ffu', 'expected' => 'name'],
            ['path' => 'dir/name.ffx.',        'suffix' => '.ffx', 'expected' => 'name'],
            ['path' => 'dir/name.fix.fix',     'suffix' => '.fix', 'expected' => 'name'],
            ['path' => 'dir/name.foo-suf',     'suffix' => '-suf', 'expected' => 'name'],
            ['path' => 'dir/name.foo.',        'suffix' => '----', 'expected' => 'name.foo'],
            ['path' => 'dir/name.foo.-ufx',    'suffix' => '-ufx', 'expected' => 'name.foo'],
            ['path' => 'dir/name.foo.ext',     'suffix' => '----', 'expected' => 'name.foo'],
            ['path' => 'dir/name.foo.ffs',     'suffix' => '.ffs', 'expected' => 'name.foo'],
        ]; //@formatter:on
    }
}
