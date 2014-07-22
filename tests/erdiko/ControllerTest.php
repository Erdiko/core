<?php

use erdiko\core\Controller;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class ControllerTest extends ErdikoTestCase
{
    var $controllerObj = null;

    function setUp()
    {
        $this->controllerObj = new \erdiko\core\Controller;
    }

    function tearDown() {
        unset($this->controllerObj);
    }

    function testSetThemeName()
    {
        $themeName = 'Test theme name';
        $this->controllerObj->setThemeName($themeName);
        $return = $this->controllerObj->getResponse()->getThemeName();
        $this->assertEquals( $return, $themeName);
    }

    function testSetThemeTemplate()
    {
        $template = 'Test theme template';
        $this->controllerObj->setThemeTemplate($template);
        $return = $this->controllerObj->getResponse()->getThemeTemplate();
        $this->assertEquals( $return, $template);
    }

    function testSetResponseDataValue()
    {
        $key = 'Test_Key';
        $value = 'Test_Value';
        $this->controllerObj->setResponseDataValue($key, $value);
        $return = $this->controllerObj->getResponse()->getDataValue($key);
        $this->assertEquals( $return, $value);
    }

    function testSetPageTitle()
    {
        $title = 'Test_Page_Title';
        $this->controllerObj->setPageTitle($title);
        $return = $this->controllerObj->getResponse()->getDataValue('page_title');
        $this->assertEquals( $return, $title);
    }


    function testSetBodyTitle()
    {
        $title = 'Test_Body_Title';
        $this->controllerObj->setBodyTitle($title);
        $return = $this->controllerObj->getResponse()->getDataValue('body_title');
        $this->assertEquals( $return, $title);
    }

    function testSetTitle()
    {
        $title = 'Test_Title';
        $this->controllerObj->setTitle($title);
        $return = $this->controllerObj->getResponse()->getDataValue('page_title');
        $this->assertEquals( $return, $title);

    }

    function testSetContent()
    {
        $content = 'Test content';
        $this->controllerObj->setContent($content);
        $return = $this->controllerObj->getResponse()->getContent();
        $this->assertEquals( $return, $content);
    }

    function testAppendContent()
    {
        //Set content
        $content = 'Test content';
        $this->controllerObj->setContent($content);
        $return = $this->controllerObj->getResponse()->getContent();
        $this->assertEquals( $return, $content);
        
        //Set appended content
        $appContent = 'Test appended content.....';
        $this->controllerObj->appendContent($appContent);
        $return = $this->controllerObj->getResponse()->getContent();
        $this->assertEquals( $return, $content.$appContent);
    }

    function testUrlToActionName()
    {
        //First Test
        $site = 'http://erdiko.com/';
        $return = $this->controllerObj->urlToActionName( $site, 'get');
        $this->assertEquals($return, 'get'.ucfirst($site));
        
        //Second Test
        $site = 'www.erdiko.com/';
        $return = $this->controllerObj->urlToActionName( $site, 'get');
        $this->assertEquals($return, 'get'.ucfirst($site));
    }

    function testSetViewAndGetView()
    {
        //First Test
        //View without data
        $view = new \erdiko\core\View('examples/helloworld');
        $this->controllerObj->setView('examples/helloworld');
        $return = $this->controllerObj->getResponse()->getContent();
        $this->assertEquals( $return, $view->toHtml());
    
        //Second Test
        //View with data
        $data = 'Test Data';
        $view = new \erdiko\core\View('examples/helloworld', $data);
        $this->controllerObj->setView('examples/helloworld', $data);
        $return = $this->controllerObj->getResponse()->getContent();
        $this->assertEquals( $return, $view->toHtml());
    }


    function testAddView()
    {
        //Set a view
        $view = new \erdiko\core\View('examples/helloworld');
        $this->controllerObj->setView('examples/helloworld');
        $return = $this->controllerObj->getView('examples/helloworld');
        $this->assertEquals( $return, $view->toHtml());
        
        //Add a view
        $data = 'Test Data';
        $view2 = new \erdiko\core\View('examples/carousel', $data);
        $this->controllerObj->addView('examples/carousel', $data);
        $return = $this->controllerObj->getResponse()->getContent();
        $this->assertEquals( $return, $view->toHtml().$view2->toHtml());
        
    }

    function testGetLayout()
    {
        //First test: Setting a theme object
        $controllerObj = new \erdiko\core\Controller;

        $theme = new erdiko\core\Theme('bootstrap', null, 'default');
        $controllerObj->getResponse()->setTheme($theme);
        $return = $controllerObj->getLayout('1column', null);

        //Get content through file_get_contents function
        $themeFolder = $controllerObj->getResponse()->getTheme()->getThemeFolder();
        $fileName = $themeFolder.'/templates/layouts/1column.php';
        $content = file_get_contents($fileName);
        //Search for the keyword which is right before php tag
        $pos = strrpos($content, 'role="main">');
        $content = substr($content, 0, $pos);
        //Check if two content are matched
        $find = strrpos($return, $content);
        $this->assertGreaterThanOrEqual(0, $find);

        unset($controllerObj);
        

        //Second test: Setting the theme name
        $controllerObj = new \erdiko\core\Controller;   
        $controllerObj->getResponse()->setThemeName('bootstrap');
        $return = $controllerObj->getLayout('1column', null);

        //Validate content
        $find = strrpos($return, $content);
        $this->assertGreaterThanOrEqual(0, $find);

        unset($controllerObj);
    }

    function testParseArguments()
    {
        //First Test
        $return = $this->controllerObj->parseArguments('test/parse');
        $tempArr = Array('test', 'parse');
        $this->assertEquals( $return, $tempArr);
        
        //Second Test
        $return = $this->controllerObj->parseArguments('test/parse/arguments');
        $tempArr = Array('test', 'parse', 'arguments');
        $this->assertEquals( $return, $tempArr);
    }

    function testCompileNameValue()
    {
        //Pass an array to compileNameValue function
        $tempArr = Array(1, 2, 3, 4, 5, 6);
        $return = $this->controllerObj->compileNameValue($tempArr);

        $tempArr2 = Array(
                        1 => 2,
                        3 => 4,
                        5 => 6,
                        );

        //Validate the two array
        $this->assertEquals($return, $tempArr2);
    }


    function testRedirect()
    {
        //$url = 'http://erdiko.com';
        //$this->controllerObj->redirect($url);

    }


  }
?>