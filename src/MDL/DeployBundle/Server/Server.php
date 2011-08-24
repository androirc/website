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

namespace MDL\DeployBundle\Server;

class Server
{
    protected $host;
    protected $port;
    protected $user;
    protected $dir;

    public function __construct($host, $user, $dir, $port = 22)
    {
        if (substr($dir, -1) != '/') {
            $dir .= '/';
        }

        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->dir = $dir;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function getSSHInformations()
    {
        return sprintf('"ssh -p%s"', $this->port);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getLoginInformations()
    {
        return sprintf('%s@%s:%s', $this->user, $this->host, $this->dir);
    }
}
