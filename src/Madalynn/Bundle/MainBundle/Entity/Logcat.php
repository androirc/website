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
    protected $crashReport;

    private static $regex = '/^(\d{2}-\d{2} \d{2}:\d{2}:\d{2}\.\d{3})(?:\s)*(\d{4})(?:\s)*(\d{4}) (\D) (.*?): (.*)$/i';

    protected $content = array();

    private $parsed = false;

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
     * Set crash report
     *
     * @param CrashReport $crashReport
     * @return Logcat
     */
    public function setCrashReport(CrashReport $crashReport = null)
    {
        $this->crashReport = $crashReport;

        return $this;
    }

    /**
     * Get crash report
     *
     * @return CrashReport
     */
    public function getCrashReport()
    {
        return $this->crashReport;
    }

    /**
     * Set logcat
     *
     * @param string $logcat
     *
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

    public function getContent()
    {
        $this->ensureParsed();

        return $this->content;
    }

    /**
     * Ensure we only parse once this logcat
     */
    private function ensureParsed()
    {
        if (false === $this->parsed) {
            $this->parse();
            $this->parsed = true;
        }
    }

    /**
     * Parse the logcat lines and extract various components
     */
    private function parse()
    {
        // Logcat format
        // mm-dd hh:mm:ss.ppp PID TID LEVEL TAG: Message
        $lines = explode("\n", $this->logcat);
        foreach ($lines as $line) {
            $matches = array();
            if (preg_match(self::$regex, $line, $matches)) {
                $this->content[] = array(
                    'date' => \DateTime::createFromFormat("m-d H:i:s.u ", $matches[1], new \DateTimeZone('UTC')),
                    'pid' => $matches[2],
                    'tid' => $matches[3],
                    'level' => $matches[4],
                    'tag' => $matches[5],
                    'message' => $matches[6]
                );
            }
        }
    }
}