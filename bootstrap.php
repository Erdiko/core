<?php
// @note should we fully deprecate the globals?
// define('ERDIKO_ROOT', dirname(dirname(dirname(__DIR__))));
// define('ERDIKO_PUBLIC', ERDIKO_ROOT.'/public');
// define('ERDIKO_APP', ERDIKO_ROOT.'/app');
// define('ERDIKO_VAR', ERDIKO_ROOT.'/var');

// @todo move this function
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = ERDIKO_ROOT.'/public'.$url['path'];
    if (is_file($file)) {
        return false;
    }
}
