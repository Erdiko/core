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


class File extends \erdiko\core\datasource\File implements CacheInterface 
{
	protected $_fileData = array();
	
	public function __construct($cacheDir=null)
	{
		if(!isset($cacheDir))
		{
			$cacheDir = VARROOT."/cache";
		}
		parent::__construct($cacheDir);
	}

	public function getKeyCode($key)
	{
		return md5($key);
	}

	public function put($key, $data)
	{
		$filename = $this->getKeyCode($key);
		$data = json_encode($data);
		$this->write($data, $filename);
	}
	
	public function get($key)
	{
		$filename = $this->getKeyCode($key);

		if($this->fileExists($filename))
			$value = $this->read($filename);
		else
			return null;

		return json_decode($value, true);
	}
	
	public function forget($key)
	{
		$filename = $this->getKeyCode($key);
		$this->delete($filename);
	}

	public function forgetAll()
	{
		$files = glob( VARROOT."/cache/*");
		foreach($files as $file){
  			if(is_file($file))
  			{	
    			$this->delete(basename($file));
    		}
		}
	}
	public function has($key)
	{
		$filename = $this->getKeyCode($key);
		return $this->fileExists($filename);	
	}
	
}