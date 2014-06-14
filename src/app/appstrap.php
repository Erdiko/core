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

ToroHook::add("500", function() {
    echo "Sorry, something went wrong";
});

ToroHook::add("", function($routes=null, $discovered_handler=null, $request_method=null, $regex_matches=null, $result=null) {
	try{
		// @todo try to render the response
		// if(is_subclass_of($result, '\erdiko\Response'))
		// { echo $result->render(); // can render as html, json, or xml }
		// else { echo $result; }
		
	} catch (\Exception $e) {
		error_log("render exception: ".$e->getMessage());  // @todo swap to log to erdiko log
		ToroHook::fire('500');
	}
	
});