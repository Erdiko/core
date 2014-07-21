<?php

use erdiko\core\AjaxController;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class AjaxControllerTest extends ErdikoTestCase
{
    var $AjaxControllerObj = null;

    function setUp()
    {
        $this->AjaxControllerObj = new \erdiko\core\AjaxController;
    }

    function tearDown() {
        unset($this->AjaxControllerObj);
    }

    function testNoFunctino()
    {
        //There is no function in AjaxController class   
    }

  }
?>