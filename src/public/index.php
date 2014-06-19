<?php
/**
 * Index file
 * Intercepts all requests and dispatches to routing
 * 
 * @category  	Erdiko
 * @package   	Public
 * @copyright 	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author		John Arroyo
 */

include_once dirname(__DIR__)."/vendor/erdiko/bootstrap.php";

try {
	$routes = Erdiko::getRoutes();

	Toro::serve(array(
    	"/" => "app\controllers\Example",
    	"/article/:alpha" => "ArticleHandler",
    	"/article/:alpha/comment" => "CommentHandler"
	));

} catch(\Exception $e) {
	echo $e->getMessage();
	// @todo return a 500 error
}