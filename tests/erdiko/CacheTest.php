<?php

use erdiko\core\Cache;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class CacheTest extends ErdikoTestCase
{
    var $cacheObj=null;
    var $webRoot;

    function setUp() {
        //$this->cacheObj = Cache;
        $webRoot = dirname(dirname(__DIR__));
    }

    function tearDown() {
        //$this->cacheObj->forgetALL();
        Cache::forgetALL();
        
        //unset($this->cacheObj);
    }
	
	function testGetCacheObject()
	{
		//$this->webRoot.'/src/app/application/default.json'
		Cache::getCacheObject();
	}

	function testGetAndPut()
	{
		Cache::put("test1","test1");
		$return= Cache::get("test1");
		//echo $return;
		//$this->assertTrue($return == "test1");
	}

/*
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
*/
  }
?>