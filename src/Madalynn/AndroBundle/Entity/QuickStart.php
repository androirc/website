<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\AndroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Madalynn\AndroBundle\Repository\QuickStartRepository")
 * @ORM\Table(name="andro_quick_start")
 */
class QuickStart
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=10)
     */
    protected $language;

    /**
     * @ORM\Column(length=20)
     */
    protected $version_min;

    /**
     * @ORM\Column(length=20)
     */
    protected $version_max;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

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
     * Set language
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set version_min
     *
     * @param string $versionMin
     */
    public function setVersionMin($versionMin)
    {
        $this->version_min = $versionMin;
    }

    /**
     * Get version_min
     *
     * @return string
     */
    public function getVersionMin()
    {
        return $this->version_min;
    }

    /**
     * Set version_max
     *
     * @param string $versionMax
     */
    public function setVersionMax($versionMax)
    {
        $this->version_max = $versionMax;
    }

    /**
     * Get version_max
     *
     * @return string
     */
    public function getVersionMax()
    {
        return $this->version_max;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
    }
}