<?php

//include "maintenance.php";

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../app/autoload.php';
$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

$loader = new ApcClassLoader('androirc', $loader);
$loader->register(true);

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
