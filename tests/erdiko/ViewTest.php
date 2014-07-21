<?php

use erdiko\core\View;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class ViewTest extends ErdikoTestCase
{
    var $viewObj = null;

    function setUp()
    {
        $this->viewObj = new \erdiko\core\View;
    }

    function tearDown() {
        unset($this->viewObj);
    }

    function testNoFunctino()
    {
        //There is no function in view class
    }

  }
?>