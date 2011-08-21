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
 * @ORM\Entity(repositoryClass="Madalynn\AndroBundle\Repository\BetaReleaseRepository")
 * @ORM\Table(name="andro_beta_release")
 * @ORM\HasLifecycleCallbacks
 */
class BetaRelease
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=100)
     */
    protected $version;

    /**
     * @ORM\OneToMany(targetEntity="Madalynn\AndroBundle\Entity\BetaDownload", mappedBy="beta_release")
     */
    protected $downloads;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $downloadable;

    /**
     * @ORM\Column(length=255)
     */
    protected $path;

    /**
     * @ORM\Column(type="integer")
     */
    protected $revision;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function __construct()
    {
        $this->downloads = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function created()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime();
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
     * Set version
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set downloadable
     *
     * @param boolean $isDownloadable
     */
    public function setDownloadable($isDownloadable)
    {
        $this->downloadable = $isDownloadable;
    }

    /**
     * Get downloadable
     *
     * @return boolean
     */
    public function isDownloadable()
    {
        return $this->downloadable;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set revision
     *
     * @param integer $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
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
     * Add downloads
     *
     * @param Madalynn\AndroBundle\Entity\BetaDownload $downloads
     */
    public function addDownloads(\Madalynn\AndroBundle\Entity\BetaDownload $downloads)
    {
        $this->downloads[] = $downloads;
    }

    /**
     * Get downloads
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDownloads()
    {
        return $this->downloads;
    }
}