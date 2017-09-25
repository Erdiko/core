<?php

namespace tests\erdiko;

/**
 * Class AjaxControllerTest
 *
 * Deprecated Test, this is not compatible for Slim framework
 *
 * @package tests\erdiko
 * @group deprecated
 */
class AjaxControllerTest extends ErdikoTestCase
{
    public $AjaxControllerObj = null;

    public function setUp()
    {
        $this->AjaxControllerObj = new \erdiko\core\AjaxController;
    }

    public function tearDown()
    {
        unset($this->AjaxControllerObj);
    }

    public function testNoFunctino()
    {
        //There is no function in AjaxController class
    }
}
