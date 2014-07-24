<?php
/**
 * Cache using the filesystem
 * 
 * @category 	Erdiko
 * @package  	core
 * @copyright 	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author		Varun Brahme
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\core\cache;
use erdiko\core\cache\CacheInterface;


class Memcache implements CacheInterface 
{
	protected $_fileData = array();
	protected $memcache;
	
	public function __construct()
	{
		// Connection creation
		$this->memcache = new Memcache;
		$cacheAvailable = $this->memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);

	}

	public function __destruct()
	{
		$this->memcache->close();
	}

	public function getKeyCode($key)
	{
		return md5($key);
	}

	public function put($key, $data)
	{
		$filename = $this->getKeyCode($key);
		$data = json_encode($data);
		$this->memcache->set($data, $filename);
	}
	
	public function get($key)
	{
		$filename = $this->getKeyCode($key);

		$value = $this->read($filename);

		if ($value != false)
			return json_decode($value, true);
		else 
			return null;
	}

	public function has($key)
	{
		
		$filename = $this->getKeyCode($key);

		$value = $this->read($filename);

		if ($value != false)
			return true;
		else 
			return null;
	}
	
	public function forget($key)
	{
		$filename = $this->getKeyCode($key);
		$memcache_obj->delete($filename);
	}

	public function forgetAll()
	{
		$memcache_obj->flush();
	}
	
}