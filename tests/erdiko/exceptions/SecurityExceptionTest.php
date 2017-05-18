<?php


/**
 * SecurityExceptionTest
 *
 *
 * @category    app
 * @package     tests\erdiko\exceptions
 * @copyright   Copyright (c) 2017, Arroyo Labs, http://www.arroyolabs.com
 * @author      Leo Daidone, leo@arroyolabs.com
 */


namespace tests\erdiko\exceptions;

require_once dirname(dirname(__DIR__)).'/ErdikoTestCase.php';

use \tests\ErdikoTestCase;
use erdiko\exceptions\SecurityException;

class SecurityExceptionTest extends  ErdikoTestCase
{
	/**
	 * @expectedException
	 * @expectedExceptionMessage This is a new exception
	 */
	public function testSecurityException()
	{
		try {
			$this->throwSecurityException();
		} catch (SecurityException $es) {
			$this->assertInstanceOf('SecurityException', $es);
			$this->assertEquals('This is a new exception',$es->getMessage());
		}
	}

	protected function throwSecurityException()
	{
		throw new SecurityException("This is a new exception");
	}
}