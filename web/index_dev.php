<?php

require_once __DIR__.'/../vendor/autoload.php';

$environment = 'development';

$app = require __DIR__.'/../app/app.php';

$app->run();
