<?php
/** 
 * appstrap: 
 * Add any application defined bootstrap items here
 */
ini_set('display_errors', '1');

// Turn on Session (uncomment line below)
// require_once ERDIKO.'/core/session.php';

/**
 * Hooks
 */
ToroHook::add("404", function() {
    echo "Sorry, we cannot find that URL";
});

ToroHook::add("500", function($msg = "") {
    echo "Sorry, something went wrong";
});
