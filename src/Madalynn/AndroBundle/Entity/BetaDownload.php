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
 * @ORM\Entity(repositoryClass="Madalynn\AndroBundle\Repository\BetaDownloadRepository")
 * @ORM\Table(name="andro_beta_download")
 * @ORM\HasLifecycleCallbacks
 */
class BetaDownload
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Madalynn\AndroBundle\Entity\BetaRelease")
     * @ORM\JoinColumn(onDelete="CASCADE", name="beta_release_id")
     */
    protected $betaRelease;

    /**
     * @ORM\Column(length=50)
     */
    protected $location;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\PrePersist
     */
    public function created()
    {
        $this->created = new \DateTime();
    }

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
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set beta release
     *
     * @param Madalynn\AndroBundle\Entity\BetaRelease $betaRelease
     */
    public function setBetaRelease(BetaRelease $betaRelease)
    {
        $this->betaRelease = $betaRelease;
    }

    /**
     * Get beta release
     *
     * @return Madalynn\AndroBundle\Entity\BetaRelease 
     */
    public function getBetaRelease()
    {
        return $this->betaRelease;
    }
}