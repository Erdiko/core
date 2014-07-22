<?php
/**
 * Example of how to set up a unit test
 * Test the functionality of the Erdiko framework static methods
 */
require_once dirname(__DIR__).'/ErdikoTestCase.php';
use erdiko\core\Logger;

class ErdikoTest extends ErdikoTestCase
{
	function tearDown() {

		$webRoot = dirname(dirname(__DIR__));

		$fileObj = new \erdiko\core\datasource\File;
		$fileObj->delete("erdiko_default.log", $webRoot."/src/vendor/var/logs");
		$fileObj->delete("erdiko_error.log", $webRoot."/src/vendor/var/logs");

    	unset($this->fileObj);
    }

    public function testGetConfigFile()
    {	
    	$content = file_get_contents(APPROOT.'/config/'."application/default.json");
        $content = str_replace("\\", "\\\\", $content);
        $content = json_decode($content, TRUE);

    	$return = Erdiko::getConfigFile(APPROOT.'/config/'."application/default.json");
		$this->assertEquals($return, $content);
	}

	public function testConfig()
	{
		$this->assertTrue(Erdiko::getConfig("application/default") != false);
	}

	public function testSendEmail()
	{
		Erdiko::sendEmail("To@arroyolabs.com", "Test Heading", "Test Body", "From@arroyolabs.com");
	}

	public function testGetRoutes()
	{
		$this->assertTrue(Erdiko::getRoutes() != false);
	}

	public function testCreateLogs()
	{
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
		$fileObj = new \erdiko\core\datasource\File;
		$webRoot = dirname(dirname(__DIR__));

		$sampleText="This is a sample log for Erdiko class test";
		
		Erdiko::log($sampleText);
		$return= $fileObj->read("erdiko_default.log", $webRoot."/src/vendor/var/logs");
		$this->assertTrue(strpos($return,$sampleText) != false );	

		Erdiko::log($sampleText, null, "exceptionLog");
		$return= $fileObj->read("erdiko_error.log", $webRoot."/src/vendor/var/logs");
		$this->assertTrue(strpos($return,$sampleText) != false );	
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