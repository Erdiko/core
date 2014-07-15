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
	public function set($key,$data);
	
	public function get($key);
	
	public function delete($key);
	
	public function exists($key);
	
	public function clearCache();
}
