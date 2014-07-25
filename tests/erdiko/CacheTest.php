<?php

use erdiko\core\Cache;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class CacheTest extends ErdikoTestCase
{
    var $cacheObj=null;

    function setUp() {
        //Cache::forgetAll('memcache');
    }

    function tearDown() {
        Cache::forgetALL();
        Cache::forgetALL('memcached');
        unset($this->cacheObj);
    }
	
	function testGetCacheObject()
	{
		Cache::getCacheObject();
	}

	function testGetAndPut()
	{
		/**
		 *	Precondition
		 *
		 *  Check if there is nothing
		 */

		$key = 'stringTest';
		$return = Cache::has($key);
		$this->assertFalse($return);

		/**
		 *	String Test
		 *
		 *  Pass a string data to cache
		 */
		Cache::put($key,"test");
		$return=Cache::get($key);
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
		Cache::put($key,$arr);
		$return=Cache::get($key);
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
		Cache::put($key,$arr);
		$return=Cache::get($key);
		$this->assertEquals($return, $arr);

		/**
		 *
		 *	Memcache Test
		 *
		 *
		 **/
		/**
		 *	Precondition
		 *
		 *  Check if there is nothing
		 */

		$memcache = 'memcached';
		$key = 'stringTest';
		$return = Cache::has($key, $memcache);
		$this->assertFalse($return);

		/**
		 *	String Test
		 *
		 *  Pass a string data to cache
		 */
		Cache::put($key,"test", $memcache);
		$return=Cache::get($key, $memcache);
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
		//Cache::put($key,$arr, $memcache);
		//$return=Cache::get($key, $memcache);
		//$this->assertEquals($return, $arr);

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
		Cache::put($key,$arr, $memcache);
		$return=Cache::get($key, $memcache);
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
		$return = Cache::has($key);
		$this->assertFalse($return);

		//Add a data
		Cache::put($key, $data);

		//Check if the data exists
		$return = Cache::has($key);
		$this->assertTrue($return);


		/**
		 *	Memcache
		 *
		 *  Precondition
		 *
		 *  Check if there is nothing
		 */
		$memcache = 'memcached';
		$key = 'Test_Key';
		$data = 'Test_Data';
		$return = Cache::has($key, $memcache);
		$this->assertFalse($return);

		//Add a data
		Cache::put($key, $data, $memcache);

		//Check if the data exists
		$return = Cache::has($key, $memcache);
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
		$return = Cache::has($key);
		$this->assertFalse($return);

		//Add a data
		Cache::put($key, $data);

		//Check if the data exists
		$return = Cache::has($key);
		$this->assertTrue($return);

		/**
		 *  Remove the data
		 */
		Cache::forget($key);
		
		//Check if the data being removed
		$return = Cache::has($key);
		$this->assertFalse($return);

		/**
		 *	Memcache
		 *
		 *  Precondition
		 *
		 *  Check if there is nothing
		 */
		$memcache = 'memcached';
		$key = 'Test_Key';
		$data = 'Test_Data';
		$return = Cache::has($key, $memcache);
		$this->assertFalse($return);

		//Add a data
		Cache::put($key, $data, $memcache);

		//Check if the data exists
		$return = Cache::has($key, $memcache);
		$this->assertTrue($return);

		/**
		 *  Remove the data
		 */
		Cache::forget($key, $memcache);
		
		//Check if the data being removed
		$return = Cache::has($key, $memcache);
		$this->assertFalse($return);
	}	
	
	function testForgetAll()
	{
		/**
		 *	Insert two data
		 */
		//First Data
		$key = 'Test_Key';
		$data = 'Test_Data';
		Cache::put($key,$data);
		$return=Cache::get($key);
		$this->assertEquals($return, $data);

		/**
		 *	Validate the data
		 */
		$return = Cache::has($key);
		$this->assertTrue($return);

		//Second Data
		$key2 = 'Test_Key2';
		$data2 = 'Test_Data2';
		Cache::put($key2,$data2);
		$return=Cache::get($key2);
		$this->assertEquals($return, $data2);

		/**
		 *	Validate the data
		 */
		$return = Cache::has($key);
		$this->assertTrue($return);

		/**
		 *	Remove all data
		 */
		Cache::forgetALL();

		//Check if all data are removed
		$return = Cache::has($key);
		$this->assertFalse($return);
		$return = Cache::has($key2);
		$this->assertFalse($return);


		/**
		 *	Memcache
		 *
		 *	Insert two data
		 */
		$memcache = 'memcached';
		//First Data
		$key = 'Test_Key';
		$data = 'Test_Data';
		Cache::put($key,$data, $memcache);
		$return=Cache::get($key, $memcache);
		$this->assertEquals($return, $data);

		/**
		 *	Validate the data
		 */
		$return = Cache::has($key, $memcache);
		$this->assertTrue($return);

		//Second Data
		$key2 = 'Test_Key2';
		$data2 = 'Test_Data2';
		Cache::put($key2,$data2, $memcache);
		$return=Cache::get($key2, $memcache);
		$this->assertEquals($return, $data2);

		/**
		 *	Validate the data
		 */
		$return = Cache::has($key, $memcache);
		$this->assertTrue($return);

		/**
		 *	Remove all data
		 */
		Cache::forgetALL($memcache);

		//Check if all data are removed
		$return = Cache::has($key, $memcache);
		$this->assertFalse($return);
		$return = Cache::has($key2, $memcache);
		$this->assertFalse($return);
	}

  }
?>