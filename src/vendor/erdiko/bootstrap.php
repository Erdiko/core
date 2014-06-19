<?php
define('ROOT', dirname(dirname(__DIR__)));
define('WEBROOT', ROOT.'/public');
define('APPROOT', ROOT.'/app');

define('VENDOR', ROOT.'/vendor');
define('ERDIKO', VENDOR.'/erdiko');
define('VIEWS', ROOT.'/app/views/');

// Core framework functions (static functions)
require_once ROOT.'/Erdiko.php';

// Required Libraries
require_once VENDOR.'/ToroPHP/Toro.php';

// Core
require_once ERDIKO.'/core/autoload.php';

// Temp hack loader @todo use composer's autoloader for core
require_once ERDIKO.'/core/Controller.php';
require_once ERDIKO.'/core/ModelAbstract.php';
require_once ERDIKO.'/core/Response.php';

// Composer
require_once VENDOR.'/autoload.php';

// load the application bootstrapper (user defined)
require_once APPROOT.'/appstrap.php';