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

namespace Madalynn\Bundle\AndroBundle\Entity;

use Madalynn\Bundle\AndroBundle\Helper\StringHelper;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\AndroBundle\Repository\CrashReportRepository")
 * @ORM\Table(name="andro_crash_report")
 * @ORM\HasLifecycleCallbacks
 */
class CrashReport
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(length=200, name="phone_model")
     */
    protected $phoneModel;

    /**
     * @ORM\Column(length=200, name="android_version")
     */
    protected $androidVersion;

    /**
     * @ORM\Column(length=200, name="androirc_version")
     */
    protected $androircVersion;

    /**
     * @ORM\Column(length=200, name="thread_name")
     */
    protected $threadName;

    /**
     * @ORM\Column(type="text", name="error_message")
     */
    protected $errorMessage;

    /**
     * @ORM\Column(type="text")
     */
    protected $callstack;

    protected $explodedCallstack;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $resolved;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count;

    public function __construct()
    {
        $this->count = 1;
        $this->resolved = false;
    }

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
     * Set phoneModel
     *
     * @param string $phoneModel
     */
    public function setPhoneModel($phoneModel)
    {
        $this->phoneModel = $phoneModel;
    }

    /**
     * Get phoneModel
     *
     * @return string
     */
    public function getPhoneModel()
    {
        return $this->phoneModel;
    }

    /**
     * Set androidVersion
     *
     * @param string $androidVersion
     */
    public function setAndroidVersion($androidVersion)
    {
        $this->androidVersion = $androidVersion;
    }

    /**
     * Get androidVersion
     *
     * @return string
     */
    public function getAndroidVersion()
    {
        return $this->androidVersion;
    }

    /**
     * Set androircVersion
     *
     * @param string $androircVersion
     */
    public function setAndroircVersion($androircVersion)
    {
        $this->androircVersion = $androircVersion;
    }

    /**
     * Get androircVersion
     *
     * @return string
     */
    public function getAndroircVersion()
    {
        return $this->androircVersion;
    }

    /**
     * Set threadName
     *
     * @param string $threadName
     */
    public function setThreadName($threadName)
    {
        $this->threadName = $threadName;
    }

    /**
     * Get threadName
     *
     * @return string
     */
    public function getThreadName()
    {
        return $this->threadName;
    }

    /**
     * Set errorMessage
     *
     * @param text $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get errorMessage
     *
     * @return text
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set callstack
     *
     * @param text $callstack
     */
    public function setCallstack($callstack)
    {
        $this->callstack = $callstack;
    }

    /**
     * Get callstack
     *
     * @return text
     */
    public function getCallstack()
    {
        return $this->callstack;
    }

    /**
     * Set resolved
     *
     * @param boolean $resolved
     */
    public function setResolved($resolved)
    {
        $this->resolved = $resolved;
    }

    /**
     * Get resolved
     *
     * @return boolean
     */
    public function isResolved()
    {
        return $this->resolved;
    }

    /**
     * Set count
     *
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    public function getCrashLocation()
    {
        $lines = $this->getExplodedCallstack();

        foreach ($lines as $line) {
            if (preg_match('#at com.androirc#', $line)) {
                return $line;
            }
        }

        return null;
    }

    /**
     * Check if the crashreport is equals at this object
     *
     * @param CrashReport $crashReport
     * @return boolean
     */
    public function equals(CrashReport $crashReport)
    {
        if ($this->getCrashMessage() != $crashReport->getCrashMessage()) {
            return false;
        }

        if ($this->getCrashLocation() != $crashReport->getCrashLocation()) {
            return false;
        }

        return true;
    }

    public function getCrashMessage()
    {
        $lines = $this->getExplodedCallstack();

        return $lines[0];
    }

    public function incCount($by = 1)
    {
        $this->count += $by;

        return $this->count;
    }

    public function getMajorAndroircVersion()
    {
        $tmp = explode(' ', $this->androircVersion);

        return $tmp[0];
    }

    private function getExplodedCallstack()
    {
        if ($this->explodedCallstack) {
            return $this->explodedCallstack;
        }

        $lines = explode("\n", $this->getCallstack());

        for ($i = 0 ; $i < count($lines) ; $i++) {
            $lines[$i] = trim($lines[$i]);

            if ($lines[$i] == '') {
                unset($lines[$i]);
            }
        }

        return $this->explodedCallstack = $lines;
    }
}