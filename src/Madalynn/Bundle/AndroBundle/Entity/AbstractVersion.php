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

namespace Madalynn\Bundle\AndroBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractVersion
{
    /**
     * The major component of the version (X.y.z)
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Min(limit=0)
     */
    protected $major;

    /**
     * The minor component of the version (x.Y.z)
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Min(limit=0)
     */
    protected $minor;

    /**
     * The revision component of the version (x.y.Z)
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Min(limit=0)
     */
    protected $revision;

    /**
     * Set major
     *
     * @param integer $major
     *
     * @return AbstractVersion
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return integer
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set minor
     *
     * @param integer $minor
     *
     * @return AbstractVersion
     */
    public function setMinor($minor)
    {
        $this->minor = $minor;

        return $this;
    }

    /**
     * Get minor
     *
     * @return integer
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * Set revision
     *
     * @param integer $revision
     *
     * @return AbstractVersion
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return integer
     */
    public function getRevision()
    {
        return $this->revision;
    }
}