<?php
// boot up Erdiko

// This is for standard installations
// $bootstrap = dirname(dirname(dirname(dirname(__DIR__)))).'/app/bootstrap.php';

// This is for erdiko-dev (CI & dev)
$bootstrap = dirname(dirname(__DIR__)).'erdiko/app/bootstrap.php';

require_once $bootstrap;
