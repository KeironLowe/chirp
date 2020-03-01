<?php

use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

// Setup Dotenv
$dotEnv = \Dotenv\Dotenv::createMutable('./');
$dotEnv->load();
