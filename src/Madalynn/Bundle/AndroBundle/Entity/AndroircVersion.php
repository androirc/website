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
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\AndroBundle\Repository\AndroircVersionRepository")
 * @ORM\Table(name="andro_androirc_version")
 */
class AndroircVersion extends AbstractVersion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The state of the version (ALPHA, BETA, RC, ..)
     *
     * @ORM\Column(length=30, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\Min(limit=0)
     */
    protected $code;

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
     * Set state
     *
     * @param string $state
     *
     * @return AndroircVersion
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return AndroircVersion
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    public function __toString()
    {
        $string = parent::__toString();
        if ($this->state) {
            $string = $string.' ('.$this->state.')';
        }

        return $string;
    }
}