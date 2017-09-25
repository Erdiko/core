<?php
/**
 *
 * @todo add tests for the different template types
 */
namespace tests\erdiko;

/**
 * Class ViewTest
 *
 * Deprecated Test, View Class was replaced for Twig in SlimFramework
 *
 * @package tests\erdiko
 * @group deprecated
 */
class ViewTest extends ErdikoTestCase
{
    public $viewObj = null;

    public function setUp()
    {
        $this->viewObj = new \erdiko\core\View;
    }

    public function tearDown()
    {
        unset($this->viewObj);
    }

    public function testNoFunctino()
    {
        //There is no function in view class
    }
}
