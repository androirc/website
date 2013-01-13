<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2013 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2013 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="andro_logcat")
 * @ORM\HasLifecycleCallbacks
 */
class Logcat
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
     * @ORM\Column(type="text")
     */
    protected $logcat;
    
    /**
     * @ORM\ManyToOne(targetEntity="CrashReport", inversedBy="logcats", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="crashreport_id", referencedColumnName="id")
     */
    protected $crash_report;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
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
     * Set crash_report
     *
     * @param \Madalynn\Bundle\MainBundle\Entity\CrashReport $crashReport
     * @return Logcat
     */
    public function setCrashReport(\Madalynn\Bundle\MainBundle\Entity\CrashReport $crashReport = null)
    {
        $this->crash_report = $crashReport;
    
        return $this;
    }

    /**
     * Get crash_report
     *
     * @return \Madalynn\Bundle\MainBundle\Entity\CrashReport 
     */
    public function getCrashReport()
    {
        return $this->crash_report;
    }

    /**
     * Set logcat
     *
     * @param string $logcat
     * @return Logcat
     */
    public function setLogcat($logcat)
    {
        $this->logcat = $logcat;
    
        return $this;
    }

    /**
     * Get logcat
     *
     * @return string 
     */
    public function getLogcat()
    {
        return $this->logcat;
    }
}