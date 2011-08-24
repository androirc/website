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

namespace MDL\DeployBundle;

use MDL\DeployBundle\Server\ServerManager;
use MDL\DeployBundle\Server\Server;

class DeployerManager
{
    protected $serverManager;
    protected $directory;

    public function __construct(array $servers)
    {
        $this->serverManager = new ServerManager();

        foreach ($servers as $key => $value) {
            $server = new Server($value['host'], $value['user'], $value['dir'], $value['port']);
            $this->addServer($key, $server);
        }
    }

    public function addServer($key, $server)
    {
        $this->serverManager->add($key, $server);
    }

    public function getServer($key)
    {
        return $this->serverManager->get($key);
    }

    public function hasServer($key)
    {
        return $this->serverManager->has($key);
    }

    public function setDirectory($dir)
    {
        $this->directory = $dir;
    }

    public function getDirectory()
    {
        return $this->directory;
    }
}
