<?php

use erdiko\core\Layout;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class LayoutTest extends ErdikoTestCase
{
    var $LayoutObj = null;
    var $webRoot=null;


    function setUp()
    {

        $this->LayoutObj = new \erdiko\core\Layout;
        //$this->response = new \erdiko\core\Response;
        $this->webRoot = dirname(dirname(__DIR__));
    }

    function tearDown() {
        unset($this->LayoutObj);
    }

    function testGetTemplateFile()
    {
        $content = 'It is some content of region one';
        $this->LayoutObj->setTheme('bootstrap');
        $this->LayoutObj->setRegion('one', $content);
        $data = null;
        $return = $this->LayoutObj->getTemplateFile(APPROOT.'/'.'themes/'.$this->LayoutObj->getTheme().'/templates/layouts/1column', $data);

        //Check content
        $content = file_get_contents(APPROOT.'/'.'themes/'.$this->LayoutObj->getTheme().'/templates/layouts/1column.php');
        $pos = strrpos($content, 'role="main"');
        $content = substr($content, 0, $pos);
        $find = strrpos($return, $content);
        $this->assertTrue($find !== false); 

    }

    function testSetThemeAndGetTheme()
    {
        $theme = "Test Theme";
        $this->LayoutObj->setTheme($theme);
        $return = $this->LayoutObj->getTheme();
        $this->assertEquals($return, $theme);
    }

    function testSetRegionAndGetRegion()
    {
        $content = 'It is some content of region one';
        $this->LayoutObj->setRegion('one', $content);
        $return = $this->LayoutObj->getRegion('one');
        $this->assertEquals($return, $content);
    }

    function testSetRegions()
    {
        $this->LayoutObj->setRegions('one');
        $return = $this->LayoutObj->getRegions();
        $this->assertEquals($return, 'one');
    }

  }
?>