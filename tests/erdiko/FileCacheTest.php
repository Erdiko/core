<?php

use erdiko\core\cache\File;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class FileCacheTest extends ErdikoTestCase
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
		/**
		 *	Precondition
		 *
		 *  Check if there is nothing
		 */

		$key = 'stringTest';
		$return = $this->cacheObj->has($key);
		$this->assertFalse($return);

		/**
		 *	String Test
		 *
		 *  Pass a string data to cache
		 */
		$this->cacheObj->put($key,"test");
		$return=$this->cacheObj->get($key);
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
		$this->cacheObj->put($key,$arr);
		$return=$this->cacheObj->get($key);
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
		$this->cacheObj->put($key,$arr);
		$return=$this->cacheObj->get($key);
		$this->assertEquals($return, $arr);
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
		$return = $this->cacheObj->has($key);
		$this->assertFalse($return);

		//Add a data
		$this->cacheObj->put($key, $data);

		//Check if the data exists
		$return = $this->cacheObj->has($key);
		$this->assertTrue($return);

		/**
		 *  Remove the data
		 */
		$this->cacheObj->forget($key);
		
		//Check if the data being removed
		$return = $this->cacheObj->has($key);

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
		$return = $this->cacheObj->has($key);
		$this->assertFalse($return);

		//Add a data
		$this->cacheObj->put($key, $data);

		//Check if the data exists
		$return = $this->cacheObj->has($key);
		$this->assertTrue($return);
	}
	
	function testForgetAll()
	{
		/**
		 *	Insert two data
		 */
		//First Data
		$key = 'Test_Key';
		$data = 'Test_Data';
		$this->cacheObj->put($key,$data);
		$return=$this->cacheObj->get($key);
		$this->assertEquals($return, $data);

		/**
		 *	Validate the data
		 */
		$return = $this->cacheObj->has($key);
		$this->assertTrue($return);

		//Second Data
		$key2 = 'Test_Key2';
		$data2 = 'Test_Data2';
		$this->cacheObj->put($key2,$data2);
		$return=$this->cacheObj->get($key2);
		$this->assertEquals($return, $data2);

		/**
		 *	Validate the data
		 */
		$return = $this->cacheObj->has($key);
		$this->assertTrue($return);

		/**
		 *	Remove all data
		 */
		$this->cacheObj->forgetALL();

		//Check if all data are removed
		$return = $this->cacheObj->has($key);
		$this->assertFalse($return);
		$return = $this->cacheObj->has($key2);
		$this->assertFalse($return);
	}

  }
?>