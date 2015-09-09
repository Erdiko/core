<?php

use erdiko\core\Logger;
require_once dirname(__DIR__).'/ErdikoTestCase.php';

class LoggerTest extends ErdikoTestCase
{
    var $loggerObj;
    var $fileObj;
    var $webRoot;


    function setUp() {
		$logFiles=array(
			"default" => "erdiko_default.log",
		);

		$this->loggerObject=new Logger($logFiles);
		$this->fileObj = new \erdiko\core\datasource\File();
		$this->webRoot = \ROOT;

    }

    function tearDown() {

    	$this->loggerObject->delete("erdiko_default.log", $this->webRoot."/var/logs");
    //	$this->loggerObject->delete("erdiko_error.log", $this->webRoot."/var/logs");
    //	$this->loggerObject->delete("erdiko_test_temp_log.log", $this->webRoot."/var/logs");
        unset($this->loggerObject);
        unset($this->fileObj);
    }

    function testLog() {

        $this->loggerObject->log(\Psr\Log\LogLevel::INFO, 'This is a test log in default test file');
        $return= $this->fileObj->read("erdiko_default.log", $this->webRoot."/var/logs");
        $this->assertTrue(strpos($return,'This is a test log in default test file') != false );
        //Test the clearlog functon

        $this->loggerObject->clearLog();
        $return= $this->fileObj->read("erdiko_default.log", $this->webRoot."/var/logs");
        $return = trim($return);
        $this->assertTrue(empty($return));


        //Should log to the default log...
        $this->loggerObject->clearLog();
        // $this->loggerObject->log('This is a test log in default test file');
        $this->loggerObject->info('This is a test log in default test file');
        $return= $this->fileObj->read("erdiko_default.log", $this->webRoot."/var/logs");
        $this->assertTrue(strpos($return,'This is a test log in default test file') != false );

        //Warning Log test
        $this->loggerObject->clearLog();
        //	$this->loggerObject->log('This is a test warning log',Logger::WARNING);
        $this->loggerObject->warning('Warning {msg} created', array('msg' => 'This is a test warning log'));
        $return= $this->fileObj->read("erdiko_default.log", $this->webRoot."/var/logs");
        $this->assertTrue(strpos($return,'This is a test warning log') != false );

        //Notice Log Test
        $this->loggerObject->clearLog();
        //	$this->loggerObject->log('This is a test notice log',Logger::NOTICE,"errorLog");
        $this->loggerObject->notice('This is a test notice log');
        $return= $this->fileObj->read("erdiko_default.log", $this->webRoot."/var/logs");
        $this->assertTrue(strpos($return,'This is a test notice log') != false );

        //Error Log Test 2
        $this->loggerObject->clearLog();
        //$this->loggerObject->log(new Exception("This is a test error log 2"),null,"errorLog");
        $this->loggerObject->error('This is a test error log 2');
        $return= $this->fileObj->read("erdiko_default.log", $this->webRoot."/var/logs");
        $this->assertTrue(strpos($return,'This is a test error log 2') != false );
		
    }
  }
?>