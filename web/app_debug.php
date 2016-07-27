<?php

date_default_timezone_set("Europe/Amsterdam");

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !preg_match('/^(127\.0\.0\.1|::1|192\.168\.2\.\d+|10\.0\.\d+\.\d+|192.168.10.\d+|172\.(1[6-9]|2[0-9]|3[01])\.\d+\.\d+)$/', @$_SERVER['REMOTE_ADDR'])
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

$loader = require_once __DIR__.'/../app/autoload.php';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$env = getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'dev';

$kernel = new AppKernel($env, true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
