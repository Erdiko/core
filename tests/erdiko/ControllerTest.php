<?php

use erdiko\core\Controller;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class ControllerTest extends ErdikoTestCase
{
    var $controllerObj = null;
    var $response=null;
    var $webRoot=null;


    function setUp()
    {

        $this->controllerObj = new \erdiko\core\Controller;
        //$this->response = new \erdiko\core\Response;
        $this->webRoot = dirname(dirname(__DIR__));
    }

    function tearDown() {
        unset($this->controllerObj);
    }

    function testSetThemeName()
    {
        $themeName = 'It is a theme name';
        $this->controllerObj->setThemeName($themeName);
        $this->assertTrue($this->controllerObj->getResponse()->getThemeName() == $themeName);
    }

    function testSetThemeTemplate()
    {
        $template = 'It is a template';
        $this->controllerObj->setThemeTemplate($template);
        $this->assertTrue($this->controllerObj->getResponse()->getThemeTemplate() == $template);
    }

    function testSetResponseDataValue()
    {
        $this->controllerObj->setResponseDataValue('Test_Key', 'Test_Value');
        $this->assertTrue($this->controllerObj->getResponse()->getDataValue('Test_Key') == ('Test_Value'));
    }

    function testSetPageTitle()
    {
        $this->controllerObj->setPageTitle('Test_Page_Title');
        $this->assertTrue($this->controllerObj->getResponse()->getDataValue('page_title') == ('Test_Page_Title'));
    }


    function testSetBodyTitle()
    {
        $this->controllerObj->setBodyTitle('Test_Body_Title');
        $this->assertTrue($this->controllerObj->getResponse()->getDataValue('body_title') == ('Test_Body_Title'));
    }

    function testSetTitle()
    {
        $this->controllerObj->setTitle('Test_Title');
        $this->assertTrue($this->controllerObj->getResponse()->getDataValue('page_title') == ('Test_Title'));
        $this->assertTrue($this->controllerObj->getResponse()->getDataValue('body_title') == ('Test_Title'));
    }

    function testSetContent()
    {
        $content = 'It is the content.....';
        $this->controllerObj->setContent($content);
        $this->assertTrue($this->controllerObj->getResponse()->getContent() == $content);
    }

    function testAppendContent()
    {
        $content = 'It is the content.....';
        $this->controllerObj->setContent($content);
        $this->assertTrue($this->controllerObj->getResponse()->getContent() == $content);
    
        $appContent = 'It is the appened content.....';
        $this->controllerObj->appendContent($appContent);
        $this->assertTrue($this->controllerObj->getResponse()->getContent() == $content.$appContent);
    }

    function testAutoaction()
    {

    }

    function test_replaceActionName()
    {

    }

    function testUrlToActionName()
    {

    }

    function testSetView()
    {
        $view = 'It is a view';
        $this->controllerObj->setView($view);
        $view = new \erdiko\core\View($view, null);
        $this->assertTrue($this->controllerObj->getResponse()->getContent() == $view);
    
        $view = 'It is a view';
        $data = 'It is some data';
        $this->controllerObj->setView($view, $data);
        $view = new \erdiko\core\View($view, $data);
        $this->assertTrue($this->controllerObj->getResponse()->getContent() == $view);
    }

    function testGetView()
    {

    }

    function testAddView()
    {

    }

    function testGetLayout()
    {

    }

    function testParseArguments()
    {

    }

    function testCompileNameValue()
    {

    }

    function testAddJs()
    {

    }

    function testAddCss()
    {

    }

    function testAddPhpToJs()
    {

    }

    function testAddMeta()
    {

    }

    function testRedirect()
    {

    }

    function testGetExceptionHtml()
    {

    }
  }
?>