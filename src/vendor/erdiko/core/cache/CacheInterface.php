<?php
/**
 * Interface for all supported php caches
 * 
 * @category  	Erdiko
 * @package   	core
 * @copyright 	Copyright (c) 2012, Arroyo Labs, www.arroyolabs.com
 * @author		Varun Brahme
 */
namespace erdiko\core\cache;

interface CacheInterface
{
	public function put($key,$data);
	
	public function get($key);
	
	public function forget($key);
	
	public function has($key);
	
	public function forgetAll();
}
