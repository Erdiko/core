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

    function testUrlToActionName()
    {
        $return = $this->controllerObj->urlToActionName('http://erdiko.com/', 'get');
        $this->assertEquals($return, 'get'.ucfirst('http://erdiko.com/'));
        
        $return = $this->controllerObj->urlToActionName('www.erdiko.com/', 'get');
        $this->assertEquals($return, 'get'.ucfirst('www.erdiko.com/'));
    }

    function testSetViewAndGetView()
    {
        $view = new \erdiko\core\View('examples/helloworld', null);
        $this->controllerObj->setView('examples/helloworld');
        $this->assertEquals($this->controllerObj->getResponse()->getContent(), $view->toHtml());
    
        $view = new \erdiko\core\View('examples/helloworld', 'It is some data');
        $this->controllerObj->setView('examples/helloworld', 'It is some data');
        $this->assertEquals($this->controllerObj->getResponse()->getContent(), $view->toHtml());
    }


    function testAddView()
    {
        $view = new \erdiko\core\View('examples/helloworld', null);
        $this->controllerObj->setView('examples/helloworld');
        $this->assertTrue($this->controllerObj->getView('examples/helloworld') == $view->toHtml());
        
        $view2 = new \erdiko\core\View('examples/carousel', null);
        $this->controllerObj->addView('examples/carousel');
        $this->assertEquals($this->controllerObj->getResponse()->getContent(), $view->toHtml().$view2->toHtml());
        
    }

    function testGetLayout()
    {
        //First test: Setting a theme object
        $controllerObj = new \erdiko\core\Controller;

        $theme = new erdiko\core\Theme('bootstrap', null, 'default');
        $controllerObj->getResponse()->setTheme($theme);
        $return = $controllerObj->getLayout('1column', null);

        //Compare content
        $themeFolder = $controllerObj->getResponse()->getTheme()->getThemeFolder();
        $content = file_get_contents($themeFolder.'/templates/layouts/1column.php');
        $pos = strrpos($content, 'role="main">');
        $content = substr($content, 0, $pos);
        $find = strrpos($return, $content);
        $this->assertGreaterThanOrEqual(0, $find);

        unset($controllerObj);
        
        //Second test: Setting the theme name only

        $controllerObj = new \erdiko\core\Controller;   
        $controllerObj->getResponse()->setThemeName('bootstrap');
        $return = $controllerObj->getLayout('1column', null);

        //Compare content
        $find = strrpos($return, $content);
        $this->assertGreaterThanOrEqual(0, $find);

        unset($controllerObj);
    }

    function testParseArguments()
    {
        $return = $this->controllerObj->parseArguments('test/parse');
        $tempArr = Array('test', 'parse');
        $this->assertTrue($return == $tempArr);
        

        $return = $this->controllerObj->parseArguments('test/parse/arguments');
        $tempArr = Array('test', 'parse', 'arguments');
        $this->assertTrue($return == $tempArr);
    }

    function testCompileNameValue()
    {
        $tempArr = Array(1, 2, 3, 4, 5, 6);
        $return = $this->controllerObj->compileNameValue($tempArr);
        $tempArr2 = Array(
                        1 => 2,
                        3 => 4,
                        5 => 6,
                        );
        $this->assertTrue($return == $tempArr2);
    }


    function testRedirect()
    {
        //$url = 'http://erdiko.com';
        //$this->controllerObj->redirect($url);

    }


  }
?>