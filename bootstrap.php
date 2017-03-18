<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = dirname(dirname(dirname(__DIR__))) . '/public'.$url['path'];
    if (is_file($file)) {
        return false;
    }
}