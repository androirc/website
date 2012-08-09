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

namespace Madalynn\Bundle\MainBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Madalynn\Bundle\MainBundle\Validator\Constraints as AndroAssert;
use Knp\Bundle\MarkdownBundle\Parser\Preset\Max as MarkdownParser;

/**
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\MainBundle\Repository\ChangeLogRepository")
 * @ORM\Table(name="andro_changelog")
 * @ORM\HasLifecycleCallbacks
 *
 * @AndroAssert\File(fileProperty="file", pathProperty="path")
 */
class ChangeLog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Madalynn\Bundle\MainBundle\Entity\AndroircVersion")
     *
     * @Assert\NotNull
     */
    protected $version;

    /**
     * @ORM\Column(length=255)
     */
    protected $path;

    /**
     * @Assert\File(maxSize="6000000", mimeTypes="text/plain")
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $md5;

    /**
     * The content of the HTML file
     *
     * @var string
     */
    protected $changes;

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
     * @param AndroircVersion $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Get version
     *
     * @return AndroircVersion
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set file
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->file) {
            // Updating the MD5 hash to be sur that the
            // (Post|Pre)Update events are called
            $this->md5 = md5_file($this->file->getRealPath());
        }
    }

    /**
     * Gets the uploaded file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Gets the MD5 hash for the uploaded file
     *
     * @return string
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * Gets the filename (the path)
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Gets the absolute path where is stored the uploaded file
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * Gets the uploaded root dir where is stored the uploaded file
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/'.$this->getUploadDir();
    }

    /**
     * Gets the uploaded dir
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/changelogs';
    }

    /**
     * Updates the filename before uploaded the file
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->path = 'v'.$this->getVersion().'.html';
        }
    }

    /**
     * Removes the uploaded file
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Uploads the file
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->moveUploadedFile();
        $this->transform();
    }

    /**
     * Moves the uploaded file to the right location
     */
    protected function moveUploadedFile()
    {
        $this->file->move($this->getUploadRootDir(), $this->getPath());
        unset($this->file);
    }

    /**
     * Returns changes of the changelog
     *
     * @return null if the changelog can't be loaded or the changelog
     */
    public function getChanges()
    {
        if ($this->changes) {
            return $this->changes;
        }

        return $this->changes = file_get_contents($this->getAbsolutePath());
    }

    /**
     * Transforms the Markdown file to an html one
     */
    protected function transform()
    {
        $parser = new MarkdownParser();

        $markdown = file_get_contents($this->getAbsolutePath());
        $html = $parser->transform($markdown);

        file_put_contents($this->getAbsolutePath(), $html);
    }
}
