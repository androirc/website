<?php

//include "maintenance.php";

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../app/autoload.php';
$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

$loader = new ApcClassLoader('androirc', $loader);
$loader->register(true);

$kernel = new AppKernel('prod', false);

$request = Request::createFromGlobals();

Request::setTrustedProxies(
    // the IP address (or range) of your proxy
    ['127.0.0.1'],

    // trust *all* "X-Forwarded-*" headers
    Request::HEADER_X_FORWARDED_ALL
);

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
