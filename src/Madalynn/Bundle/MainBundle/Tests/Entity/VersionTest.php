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

namespace Madalynn\Bundle\MainBundle\Tests\Entity;

use Madalynn\Bundle\MainBundle\Entity\AndroircVersion;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataToStringRepresenation
     */
    public function testToStringRepresentation($version, $string)
    {
        $version = AndroircVersion::create($version);
        $this->assertEquals($version->__toString(), $string);
    }

    public function dataToStringRepresenation()
    {
        return array(
            array('0', '0.0'),
            array('1', '1.0'),
            array('1.2.3', '1.2.3'),
            array('foo', '0.0'),
            array('1.4', '1.4'),
            array('foo.bar.3', '0.0.3')
        );
    }

    /**
     * @dataProvider dataAccessors
     */
    public function testAccessors($version, $major, $minor, $revision)
    {
        $version = AndroircVersion::create($version);

        $this->assertEquals($major, $version->getMajor());
        $this->assertEquals($minor, $version->getMinor());
        $this->assertEquals($revision, $version->getRevision());
    }

    public function dataAccessors()
    {
        return array(
            array('3.2.1', 3, 2, 1),
            array('1.0', 1, 0, 0),
            array('3', 3, 0, 0),
            array('', 0, 0, 0),
            array('foobar', 0, 0, 0),
            array('4.2.2.2', 4, 2, 2),
        );
    }
}
