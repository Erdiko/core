<?php

use erdiko\core\Response;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class ResponseTest extends ErdikoTestCase
{
    var $ResponseObj=null;
    var $webRoot=null;

    function setUp() {
       
        $this->ResponseObj = new Response;

        $this->webRoot = dirname(dirname(__DIR__));
        //echo $this->webRoot;
    }


    function tearDown()
    {
        //unset($this->fileObj);
    }

    function testSetDataValueAndGetDataValue()
    {
        $key = 'Test_Key';
        $data = 'Test_Data';
        $this->ResponseObj->setDataValue($key, $data);
        $return = $this->ResponseObj->getDataValue($key);
        $this->assertTrue($return == $data);
    }

    function testSetTheme()
    {
        $theme = 'theme';
        $this->ResponseObj->setTheme($theme);
        $return = $this->ResponseObj->getTheme();
        $this->assertTrue($return == $theme);
    }

    function testSetThemeTemplate()
    {
        $themeTemplate = 'themeTemplate';
        $this->ResponseObj->setThemeTemplate($themeTemplate);
        $return = $this->ResponseObj->getThemeTemplate();
        $this->assertTrue($return == $themeTemplate);
    }
    
    function testSetContent()
    {
        $content = 'Here are some content';
        $this->ResponseObj->setContent($content);
        $return = $this->ResponseObj->getContent();
        $this->assertTrue($return == $content);
    }
    
    function testAppendContent()
    {
        $content = 'Here are some content';
        $this->ResponseObj->setContent($content);
        $return = $this->ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $appContent = '...more content...';
        $this->ResponseObj->appendContent($appContent);
        $return = $this->ResponseObj->getContent();
        $this->assertTrue($return == $content.$appendContent);
    }

    function testRender()
    {

    }

    function testSend()
    {

    }


  }
?>


