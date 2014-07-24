<?php

use erdiko\core\Cache;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class MemcacheTest extends ErdikoTestCase
{
    var $memcacheObj=null;

    function setUp() {
        $this->memcacheObj = Cache::getCacheObject();
    }

    function tearDown() {
        $this->memcacheObj->forgetALL();
        unset($this->cacheObj);
    }
	
	
	function testPutAndGet()
	{
		/**
		 *	Precondition
		 *
		 *  Check if there is nothing
		 */

		$key = 'stringTest';
		$return = $this->memcacheObj->has($key);
		$this->assertFalse($return);

		/**
		 *	String Test
		 *
		 *  Pass a string data to cache
		 */
		$this->memcacheObj->put($key,"test");
		$return= $this->memcacheObj->get($key);
		$this->assertEquals($return, "test");

		/**
		 *	Array Test
		 *
		 *  Pass an array data to cache
		 */
		$arr = array(
				'1' => 'test1',
				'2' => 'test2'
				);

		$key = 'arrayTest';
		$this->memcacheObj->put($key,$arr);
		$return= $this->memcacheObj->get($key);
		$this->assertEquals($return, $arr);

		/**
		 *	JSON Test
		 *
		 *  Pass a JSON data to cache
		 */
		$arr = array(
				'1' => 'test1',
				'2' => 'test2'
				);
		$arr = json_encode($arr);
		$key = 'arrayTest';
		$this->memcacheObj->put($key,$arr);
		$return= $this->memcacheObj->get($key);
		$this->assertEquals($return, $arr);
	}

	function testHas()
	{	
		/**
		 *	Precondition
		 *
		 *  Check if there is nothing
		 */

		$key = 'Test_Key';
		$data = 'Test_Data';
		$return =  $this->memcacheObj->has($key);
		$this->assertFalse($return);

		//Add a data
		$this->memcacheObj->put($key, $data);

		//Check if the data exists
		$return = $this->memcacheObj->has($key);
		$this->assertTrue($return);
	}

	function testForget()
	{
		/**
		 *	Precondition
		 *
		 *  Check if there is nothing
		 */
		$key = 'Test_Key';
		$data = 'Test_Data';
		$return = $this->memcacheObj->has($key);
		$this->assertFalse($return);

		//Add a data
		$this->memcacheObj->put($key, $data);

		//Check if the data exists
		$return = $this->memcacheObj->has($key);
		$this->assertTrue($return);

		/**
		 *  Remove the data
		 */
		$this->memcacheObj->forget($key);
		
		//Check if the data being removed
		$return = $this->memcacheObj->has($key);
	}	

	function testForgetAll()
	{
		/**
		 *	Insert two data
		 */
		//First Data
		$key = 'Test_Key';
		$data = 'Test_Data';
		$this->memcacheObj->put($key,$data);
		$return=$this->memcacheObj->get($key);
		$this->assertEquals($return, $data);

		/**
		 *	Validate the data
		 */
		$return = $this->memcacheObj->has($key);
		$this->assertTrue($return);

		//Second Data
		$key2 = 'Test_Key2';
		$data2 = 'Test_Data2';
		$this->memcacheObj->put($key2,$data2);
		$return=$this->memcacheObj->get($key2);
		$this->assertEquals($return, $data2);

		/**
		 *	Validate the data
		 */
		$return = $this->memcacheObj->has($key);
		$this->assertTrue($return);

		/**
		 *	Remove all data
		 */
		$this->memcacheObj->forgetALL();

		//Check if all data are removed
		$return = $this->memcacheObj->has($key);
		$this->assertFalse($return);
		$return = $this->memcacheObj->has($key2);
		$this->assertFalse($return);
	}


  }
?>