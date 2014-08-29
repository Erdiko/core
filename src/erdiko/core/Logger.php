<?php
/**
 * Logging utility for Erdiko
 * 
 * @category  	Erdiko
 * @package   	core
 * @copyright 	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author		Varun Brahme
 * @author		Coleman Tung, coleman@arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\core;

use erdiko\core\datasource\File;

/**
 * Logger Class
 */
class Logger extends File
{
	
	/** Log files */
	protected $_logFiles = array(
		"default" => "system.log",
	);
	protected $_defaultPath = '/var/logs';
	
	const LOG = "Log";
	const NOTICE = "Notice";
	const WARNING = "Warning";
	const EXCEPTION = "Exception";
	
	/** 
	 * Constructor 
	 * 
	 * @param array $logFiles
	 * @param string $logDir, fully qualified path or a path relative to the erdiko root
	 */
	public function __construct($logFiles = array(), $logDir = null)
	{
		// Set the log files
		if(!empty($logFiles))
			$this->_logFiles = array_merge($this->_logFiles, array_change_key_case($logFiles));
		
		// Set the logging directory
		if($logDir != null)
		{
			if(is_dir($logDir))
				$this->_filePath = $logDir; // fully qualified & valid path
			else
				$this->_filePath = \ROOT.$logDir; // otherwise assume it's relative to the root
		}
		else
		{
			$this->_filePath = \ROOT.$this->_defaultPath;
		}
	}
	
	/**
	 * Add log file
	 *
	 * @param mixed $key
	 * @param string $logFileName
	 * @return bool
	 */
	public function addLogFile($key,$logFileName)
	{
		$arrayKey=strtolower($key);
		return $this->_logFiles[$arrayKey] = $logFileName;
	}
	
	/**
	 * Remove log file
	 *
	 * @param mixed $key
	 */
	public function removeLogFile($key)
	{
		$arrayKey=strtolower($key);
		unset($this->_logFiles[$arrayKey]);
		return true;
	}
	
	/**
	 * Log
	 *
	 * @param string $log
	 * @param string $logLevel
	 * @param string $logKey 
	 * @return bool
	 */
	public function log($log, $logLevel=null, $logKey=null)
	{
		$logFileName="";
		$logString="";
		if(is_string($log))
		{
			if($logLevel==null)
				$logLevel = Logger::LOG;
			$logString=date('Y-m-d H:i:s')." ".$logLevel.": ".$log.PHP_EOL;
		}
		else
		{
			if("Exception" == get_class($log))
				$logString=date('Y-m-d H:i:s')." ".Logger::EXCEPTION.": ".$log.PHP_EOL;
		}
		
		if($logKey==null)
			$logFileName=$this->_logFiles["default"]; // If log key is null use the default log file
		else
		{
			$arrayKey=strtolower($logKey);
			if(isset($this->_logFiles[$arrayKey])) // If log key exists, use that log file
				$logFileName=$this->_logFiles[$arrayKey];
			else
				$logFileName=$this->_logFiles["default"]; // Otherwise use the default log file
		}
		
		return $this->write($logString, $logFileName, null, "a");
	}
	
	/**
	 * Clear Log
	 *
	 * @param string $logKey
	 * @return bool
	 */
	public function clearLog($logKey=null)
	{
		$ret=true;
		if($logKey==null)
		{
			foreach($this->_logFiles as $key => $logFile)
				$ret = $ret && $this->write("", $logFile);
			return $ret;
		}
		else
		{
			$arrayKey=strtolower($logKey);
			if(isset($this->_logFiles[$arrayKey]))
				return $this->write("", $this->_logFiles[$arrayKey]);
			else
				return 0;
		}
	}
	
	/** Destructor */
	public function __destruct()
	{
	}
}

?>