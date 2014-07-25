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


class MemcacheClass implements CacheInterface 
{
	protected $memcacheObj;
	
	public function __construct()
	{
		// Connection creation
		$this->memcacheObj = new \Memcache;
		$cacheAvailable = $this->memcacheObj->connect(MEMCACHED_HOST, MEMCACHED_PORT);

	}

	public function __destruct()
	{
		$this->memcacheObj->close();
		unset($this->memcacheObj);
	}

	public function getKeyCode($key)
	{
		return md5($key);
	}

	public function put($key, $data)
	{
		$key = $this->getKeyCode($key);
		$data = json_encode($data);
		$this->memcacheObj->set($key, $data);
	}
	
	public function get($key)
	{
		$key = $this->getKeyCode($key);

		$value = $this->memcacheObj->get($key);
		
		if ($value !== null)
			return json_decode($value, true);
		else 
			return null;
	}

	public function has($key)
	{
		$key = $this->getKeyCode($key);

		$value = $this->memcacheObj->get($key);
		
		if (!$value)
			return false;
		else 
			return true;
	}
	
	public function forget($key)
	{
		$filename = $this->getKeyCode($key);
		$this->memcacheObj->delete($filename);
	}

	public function forgetAll()
	{
		$this->memcacheObj->flush();
	}
	
}