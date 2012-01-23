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

use Madalynn\Bundle\AdminBundle\DataTransformer\VersionTransformer;

/**
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\AndroBundle\Repository\ChangeLogRepository")
 * @ORM\Table(name="andro_changelog")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="integer")
     */
    protected $version;

    /**
     * @ORM\Column(length=255)
     */
    protected $path;

    /**
     * @Assert\File(maxSize="6000000", mimeTypes="text/plain")
     */
    public $file;

    protected $changes;

    public function __construct()
    {
        $this->version = 0;
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
     * @param integer $version
     */
    public function setVersion($version)
    {
        $this->version = VersionTransformer::reverseTransform($version);
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return VersionTransformer::transform($this->version);
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
        return 'uploads/changelogs';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->setPath('v'.$this->getVersion());
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

    public function getChanges()
    {
        if ($this->changes) {
            return $this->changes;
        }

        $file = @file($this->getAbsolutePath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (false === $file) {
            return null;
        }

        $changes = array();

        foreach($file as $change) {
            if ('#' === substr($change, 0, 1)) {
                continue;
            }

            $pos = strpos($change, ':');

            if (false === $pos) {
                $changes[] = array(
                    'key' => '',
                    'content' => trim($change)
                );
            } else {
                list($key, $value) = explode(':', $change, 2);

                $changes[] = array(
                    'key' => $key,
                    'content' => trim($value)
                );
            }
        }

        usort($changes, array($this, 'sortChanges'));

        return $this->changes = $changes;
    }

    protected function sortChanges($a, $b)
    {
        return $this->typeToInteger($b['key']) - $this->typeToInteger($a['key']);
    }

    public function typeToInteger($type)
    {
        switch($type)
        {
            case 'added':
                return 3;
            case 'changed':
                return 2;
            case 'fixed':
                return 1;
            default:
                return 0;
        }
    }
}
