<?php

use erdiko\core\Cache;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class CacheTest extends ErdikoTestCase
{
    // contains the object handle of the string class
    var $cacheObj=null;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function setUp() {
        // create a new instance of String with the
        // string 'abc'
        $this->cacheObj = Erdiko::getCache("default");
		//$this->cacheObj = new Cache();
    }

    // called after the test functions are executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function tearDown() {
        // delete your instance
        $this->cacheObj->forgetALL();
        unset($this->cacheObj);
    }
	
	function testGetAndPut()
	{
		$this->cacheObj->put("test1","test1");
		$return=$this->cacheObj->get("test1");
		$this->assertTrue($return == "test1");
	}

	function testHas()
	{	
		$this->assertFalse($this->cacheObj->has("test2"));
		$this->cacheObj->put("test2","test2");
		$this->assertTrue($this->cacheObj->has("test2"));
	}
	
	function testForget()
	{
		$this->cacheObj->put("test3","test3");
		$this->assertTrue($this->cacheObj->has("test3"));
		$this->cacheObj->forget("test3");
		$this->assertFalse($this->cacheObj->has("test3"));
	}	
	
	function testForgetAll()
	{
		$this->cacheObj->put("test1","test1");
		$this->assertTrue($this->cacheObj->has("test1"));
		$this->assertFalse($this->cacheObj->has("test2"));

		$this->cacheObj->forgetALL();

		$this->assertFalse($this->cacheObj->has("test1"));
		$this->assertFalse($this->cacheObj->has("test2"));
	}

  }
?>