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


class Memcached implements CacheInterface 
{
	protected $memcacheObj;
	
	/**
     * Constructor
     */
	public function __construct()
	{
		// Connection creation
		$this->memcacheObj = new \Memcached;
		$cacheAvailable = $this->memcacheObj->addServer(MEMCACHED_HOST, MEMCACHED_PORT);

	}

	/**
     * Destructor
     */
	public function __destruct()
	{
		$this->memcacheObj->quit();
		unset($this->memcacheObj);
	}

	/**
     * 	MD5 encode
     *
     *	@parm mixed $key
     *	@return string $key
     */
	public function getKeyCode($key)
	{
		return md5($key);
	}


	/**
     * 	Put data into cache
     *
     *	@parm mixed $key
     *	@parm mixed $data
     */
	public function put($key, $data)
	{

		$key = $this->getKeyCode($key);
		$data = json_encode($data);
		$this->memcacheObj->set($key, $data);
	}
	
	/**
	 *
	 *  @note Any cache array will get return as object
	 *  @note If you need an array, use (array) $object
	 *
	 */
	public function get($key)
	{
		$key = $this->getKeyCode($key);
		$value = $this->memcacheObj->get($key);
		return json_decode($value);
	}

	/**
	 *
	 *  @return true if the key exist in cache
	 *  @return false if the key does not exist in cache
	 *  @note If you need an array, use (array) $object
	 *
	 */
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