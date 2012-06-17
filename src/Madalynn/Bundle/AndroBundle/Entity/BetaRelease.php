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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Madalynn\Bundle\AndroBundle\Validator\Constraints as AndroAssert;

/**
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\AndroBundle\Repository\BetaReleaseRepository")
 * @ORM\Table(name="andro_beta_release")
 * @ORM\HasLifecycleCallbacks
 *
 * @AndroAssert\File(fileProperty="file", pathProperty="path")
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
     * @ORM\ManyToOne(targetEntity="Madalynn\Bundle\AndroBundle\Entity\AndroircVersion")
     *
     * @Assert\NotNull
     */
    protected $version;

    /**
     * @ORM\OneToMany(targetEntity="Madalynn\Bundle\AndroBundle\Entity\BetaDownload", mappedBy="betaRelease")
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
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

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
        $this->downloads = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
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
     * Set file
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
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
     * @param Madalynn\Bundle\AndroBundle\Entity\BetaDownload $downloads
     */
    public function addDownloads(BetaDownload $downloads)
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

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/betas';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->setPath($this->file->getClientOriginalName());
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->getPath());

        $this->path = $this->file->getClientOriginalName();
        $this->file = null;
    }
}
