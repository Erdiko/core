<?php

use erdiko\core\Container;
require_once dirname(__DIR__).'/ErdikoTestCase.php';

class ContainerTest extends ErdikoTestCase
{
    var $containerObj;
    var $webRoot;

    function setUp() {

		$this->containerObj=new Container();
		$this->webRoot = dirname(dirname(__DIR__));

    }

    function tearDown() {

      unset($this->containerObj);
    }

    function testSetTemplate()
    {
      $temp = '/themes/bootstrap/templates/default';
      $this->containerObj->setTemplate($temp);
    }

    function testSetDataAndGetData()
   	{
      $data = 'It is some data';
      $this->containerObj->setData($data);
      $return =$this->containerObj->getData($data);
      $this->assertEquals($return, $data);
  	}

   	function testGetTemplateFolder()
   	{
      //Template Folder can only be set in its devide classes, such view, theme
      $temp = APPROOT.'/themes/bootstrap/templates/default';
      $this->containerObj->setTemplate($temp);
      $return = $this->containerObj->getTemplateFolder();
   	  //echo $return;
    }

   	function testGetTemplateFile()
   	{
      $temp = APPROOT.'/themes/bootstrap/templates/default';
      $this->containerObj->getTemplateFile($temp, null);
      echo $return;
   	}

   	function testToHtml()
   	{
      
   	}

  }
?>