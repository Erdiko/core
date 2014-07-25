<?php

use erdiko\core\AjaxResponse;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class AjaxResponseTest extends ErdikoTestCase
{
    var $ajaxResponseObj = null;

    function setUp()
    {
        $this->ajaxResponseObj = new \erdiko\core\AjaxResponse;
    }

    function tearDown() {
        unset($this->ajaxResponseObj);
    }

    function testRender()
    {
        $tempData = array(
            "status" => 500,
            "body" => null,
            "errors" => array()
            );
        $tempData = json_encode($tempData);
        $return = $this->ajaxResponseObj->render();
        $this->assertEquals($tempData, $return);
    }

  }
?>