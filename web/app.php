<?php

//include "maintenance.php";

use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../app/autoload.php';
require_once __DIR__.'/../app/bootstrap.php.cache';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
