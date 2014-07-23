<?php
/**
 * Example of how to set up a unit test
 * Test the functionality of the Erdiko framework static methods
 */
require_once dirname(__DIR__).'/ErdikoTestCase.php';
use erdiko\core\Logger;

class ErdikoTest extends ErdikoTestCase
{
    public function testGetConfigFile()
    {	
    	/**
		 *	First Test
		 */
    	//Get the config file through getConfigFile function
    	$filename = APPROOT.'/config/'."application/default.json";
    	$return = Erdiko::getConfigFile($filename);

    	//Get the config file through file_get_contents function
    	$content = file_get_contents($filename);
        $content = str_replace("\\", "\\\\", $content);
        $content = json_decode($content, TRUE);

        //Validate the config file
		$this->assertEquals($return, $content);
	}

	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function testGetConfigFileException()
    {	
		/**
		 *	Second Test
		 *  
		 *  Passing a non-exist config file
		 */
    	$fileName = APPROOT.'/config/'."non-exist.json";
    	$return = Erdiko::getConfigFile($fileName);
	}

	public function testConfig()
	{
		/**
		 *	First Test
		 */
		$filename = "application/default";
		$this->assertTrue(Erdiko::getConfig($filename) != false);
	}

	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function testConfigException()
	{
		/**
		 *	Second Test
		 *  
		 *  Passing a non-exist config file
		 */
		$fileName = "application/non-exist";
		$this->assertTrue(Erdiko::getConfig($fileName) != false);
	}

	public function testSendEmail()
	{
		Erdiko::sendEmail("To@arroyolabs.com", "Test Heading", "Test Body", "From@arroyolabs.com");
	}

	public function testGetRoutes()
	{
		//Get routes through getRoutes function
		$return = Erdiko::getRoutes();

		//Get routes through direct access
		$filename =  APPROOT.'/config/application/routes.json';
		$data = str_replace("\\", "\\\\", file_get_contents($filename));
		$json = json_decode($data, TRUE);
		
		//Validate data
		$this->assertEquals( $return, $json['routes']);
	}

	public function testCreateLogs()
	{
		//$this->assertTrue(Erdiko::$_logObject === null);
		
		$logFiles=array(
			"default" => "erdiko_default.log",
			"exceptionLog" => "erdiko_error.log",
		);
		Erdiko::createLogs($logFiles);
	}

	/**
	 *	@depends testCreateLogs	
	 */	
	public function testLogs()
	{
		//Initialize a File object locally
		$fileObj = new \erdiko\core\datasource\File;
		$webRoot = dirname(dirname(__DIR__));
		$logFolder = $webRoot."/src/vendor/var/logs";

		$sampleText="This is a sample log for Erdiko class test";
		
		//Log file will be only created when the log() is being called
		//First test
		Erdiko::log($sampleText);
		$return= $fileObj->read("erdiko_default.log", $logFolder);
		$this->assertTrue(strpos($return,$sampleText) !== false );	

		//Second test
		Erdiko::log($sampleText, null, "exceptionLog");
		$return= $fileObj->read("erdiko_error.log", $logFolder);
		$this->assertTrue(strpos($return,$sampleText) !== false );	
	}

	public function getCache()
	{
		//Reture false if config file is not existed
		$this->assertTrue(Erdiko::getCache("default"));
	}

	public function testGetTemplate()
	{
		//Deprecated function
	}
	
}