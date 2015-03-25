<?php

/**
 * @file Web based/RESTful application
 */

$app = require_once __DIR__ . '/bootstrap.php';

/***********************************************
 * Register controllers
 ***********************************************/

$core = new \StatutesOnline\Controller\ControllerProvider();
$app->register($core);
$app->mount('/', $core);

/***********************************************
 * Serve the pages
 ***********************************************/

if ( $app['use_cache'] === true ) {

  return $app['http_cache'];
}
else {

  return $app;
}
