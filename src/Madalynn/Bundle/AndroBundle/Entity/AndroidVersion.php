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
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\AndroBundle\Repository\AndroidVersionRepository")
 * @ORM\Table(name="andro_android_version")
 */
class AndroidVersion extends AbstractVersion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="api_level")
     *
     * @Assert\Min(limit=1)
     */
    protected $apiLevel;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set apiLevel
     *
     * @param integer $apiLevel
     *
     * @return AndroidVersion
     */
    public function setApiLevel($apiLevel)
    {
        $this->apiLevel = $apiLevel;

        return $this;
    }

    /**
     * Get apiLevel
     *
     * @return integer
     */
    public function getApiLevel()
    {
        return $this->apiLevel;
    }
}