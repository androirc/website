<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2012 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2012 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\Bundle\AndroBundle\Tests\Entity;

use Madalynn\Bundle\AndroBundle\Entity\AndroircVersion;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreationVersion()
    {
        $versions = array(
            '0'         => '0.0',
            '1'         => '1.0',
            '1.2.3'     => '1.2.3',
            'foo'       => '0.0',
            '1.4'       => '1.4',
            'foo.bar.3' => '0.0.3'
        );

        foreach ($versions as $key => $value) {
            $version = AndroircVersion::create($key);
            $this->assertSame($version->__toString(), $value);
        }
    }
}