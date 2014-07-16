<?php
/**
 * Example of how to set up a unit test
 * Test the functionality of the Erdiko framework static methods
 */
require_once dirname(__DIR__).'/ErdikoTestCase.php';
use erdiko\core\Logger;

class ErdikoTest extends ErdikoTestCase
{
	var $cacheObj=null;

/*
    function setUp() {
        $this->cacheObj = Erdiko::getCache("default");
		//$this->cacheObj = new Cache();
    }

    function tearDown() {
        $this->cacheObj->forgetALL();
        unset($this->cacheObj);
    }
	*/
	public function testConfig()
	{
		//Erdiko::getConfig("application/default");
	}

	public function testSendEmail()
	{
		//Erdiko::sendEmail("coleman@arroyolabs.com", "Email Test", "Test Body", "google@google.com");
	}

	/*
	public function testWriteToFileAndReadFromFileThenDelete()
	{
		$webRoot = dirname(dirname(__DIR__));
		$string="Sample string";
		Erdiko::writeToFile($string,"sample.txt");
		$result=Erdiko::readFromFile("sample.txt");
        $this->assertTrue($result == $string);
		
		$string="Sample string";
		Erdiko::writeToFile($string,"sample.txt",$webRoot);
		$result2=Erdiko::readFromFile("sample.txt",$webRoot);
        $this->assertTrue($result2 == $string);
		
		Erdiko::deleteFile("sample.txt");
		$this->assertTrue(file_exists($webRoot."www/var/sample.txt") == false);
		
		Erdiko::deleteFile("sample.txt",$webRoot."");
		$this->assertTrue(file_exists($webRoot."/sample.txt") == false);
	}
*/

	public function testCreateLogs()
	{
		$logFiles=array(
			"default" => "erdiko_default.log",
			"exceptionLog" => "erdiko_error.log",
		);
		Erdiko::createLogs($logFiles);

	}

	
	public function testLogs()
	{
		$webRoot = dirname(dirname(__DIR__));
		$fileObject = new File;
		$fileObject->read($webRoot);
		$sampleText="This is a sample log for Erdiko class test";
		
		Erdiko::log($sampleText);
		//$return=Erdiko::readFromFile("erdiko.log",$webRoot."/www/var/logs");
		//$this->assertTrue(strpos($return,$sampleText) != false );
		
		/*
		Erdiko::clearLog();
		$return=Erdiko::readFromFile("erdiko.log",$webRoot."/www/var/logs");
		$this->assertTrue(empty($return)==true);
		
		Erdiko::clearLog();
		Erdiko::log($sampleText,Logger::INFO);
		$return=Erdiko::readFromFile("erdiko.log",$webRoot."/www/var/logs");
		$this->assertTrue(strpos($return,$sampleText) != false && strpos($return,"Info") != false);
		
		Erdiko::clearLog();
		Erdiko::log($sampleText,Logger::ERROR,"exception");
		$return=Erdiko::readFromFile("erdiko_error.log",$webRoot."/www/var/logs");
		$this->assertTrue(strpos($return,$sampleText) != false && strpos($return,"Error") != false);
		
		Erdiko::clearLog();
		Erdiko::log(new Exception($sampleText),null,"exception");
		$return=Erdiko::readFromFile("erdiko_error.log",$webRoot."/www/var/logs");
		$this->assertTrue(strpos($return,$sampleText) != false );	
		*/
	}
	
}