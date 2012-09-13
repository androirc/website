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

class AndroircVersionTest extends \PHPUnit_Framework_TestCase
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
            array('foo.bar.3', '0.0.3'),
            array('4.0.0-BETA-1', '4.0-BETA-1'),
            array('4.0.0-beta-2', '4.0-BETA-2'),
        );
    }

    /**
     * @dataProvider dataAccessors
     */
    public function testAccessors($version, $major, $minor, $revision, $state)
    {
        $version = AndroircVersion::create($version);

        $this->assertEquals($major, $version->getMajor());
        $this->assertEquals($minor, $version->getMinor());
        $this->assertEquals($revision, $version->getRevision());
        $this->assertEquals($state, $version->getState());
    }

    public function dataAccessors()
    {
        return array(
            array('3.2.1', 3, 2, 1, null),
            array('1.0', 1, 0, 0, null),
            array('3', 3, 0, 0, null),
            array('', 0, 0, 0, null),
            array('foobar', 0, 0, 0, null),
            array('4.2.2.2', 4, 2, 2, null),
            array('foo-beta-1', 0, 0, 0, 'beta-1'),
            array('4.0-ALPHA-3', 4, 0, 0, 'ALPHA-3'),
            array('4.1.2-RC1', 4, 1, 2, 'RC1'),
        );
    }
}
