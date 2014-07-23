<?php

use erdiko\core\Response;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class ResponseTest extends ErdikoTestCase
{
    var $ResponseObj=null;

    function setUp() {
        $this->ResponseObj = new Response;
    }

    function tearDown()
    {
        unset($this->ResponseObj);
    }

    /**
     * @expectedException
     */
    function testSetDataValueAndGetDataValue()
    {
        /**
         * First test
         * 
         * Set a key and then get the key
         */
        $key = 'Test_Key';
        $data = 'Test_Data';
        $this->ResponseObj->setDataValue($key, $data);
        $return = $this->ResponseObj->getDataValue($key);
        $this->assertTrue($return == $data);

        /**
         * Second test
         * 
         * Try to get a non exist key
         */
        $key = 'Test_Non_Exist_Key';
        //$return = $this->ResponseObj->getDataValue($key);
        //var_dump($return);

        //$this->assertTrue($return == $data);
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
        $content = 'Test content';
        $this->ResponseObj->setContent($content);
        $return = $this->ResponseObj->getContent();
        $this->assertTrue($return == $content);
    }
    
    function testAppendContent()
    {
        $content = 'Test content';
        $this->ResponseObj->setContent($content);
        $return = $this->ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $appContent = 'Second test content';
        $this->ResponseObj->appendContent($appContent);
        $return = $this->ResponseObj->getContent();
        $this->assertTrue($return == $content.$appContent);
    }

    function testRender()
    {
        /** 
         *
         *  Test the first condition in render()
         *
         */
        $ResponseObj = new Response;

        //Set a theme object
        $theme = new erdiko\core\Theme('bootstrap', null, 'default');
        $ResponseObj->setTheme($theme);
        //Get the theme object and check if they are the same object
        $return = $ResponseObj->getTheme();
        $this->assertTrue($return == $theme);

        //Add content
        $content = 'Test content';
        $ResponseObj->setContent($content);
        //Get content and validate the content
        $return = $ResponseObj->getContent();
        $this->assertTrue($return == $content);

        //Perform the render function
        $return = $ResponseObj->render();
        
        
        /** 
         *  Validate the content
         */
        $themeFolder = $ResponseObj->getTheme()->getThemeFolder();
        
        //Header
        $header = file_get_contents($themeFolder.'/templates/page/header.php');
        $pos = strrpos($header, 'navbar-brand');
        $header = substr($header, 0, $pos);
        $find = strrpos($return, $header);
        $this->assertTrue($find != false);

        //Footer
        $footer = file_get_contents($themeFolder.'/templates/page/footer.php');
        $pos = strrpos($footer, 'nav nav-justified');
        $footer = substr($footer, 0, $pos);
        $find = strrpos($return, $footer);
        $this->assertTrue($find != false);

        //Content
        $find = strrpos($return, $content);
        $this->assertTrue($find != false);

        unset($ResponseObj);

        /** 
         *
         *  Test the second condition in render()
         *
         */
        $ResponseObj = new Response;
        

        $ResponseObj->setThemeName('bootstrap');
        $return = $ResponseObj->getTheme();
        
        //Add some content
        $content = 'Test content';
        $ResponseObj->setContent($content);
        $return = $ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $return = $ResponseObj->render();
        
        /** 
         *  Validate the content
         */
        $themeFolder = $ResponseObj->getTheme()->getThemeFolder();
        
        //Header
        $header = file_get_contents($themeFolder.'/templates/page/header.php');
        $pos = strrpos($header, 'navbar-brand');
        $header = substr($header, 0, $pos);
        $find = strrpos($return, $header);
        $this->assertTrue($find != false);

        //Footer
        $footer = file_get_contents($themeFolder.'/templates/page/footer.php');
        $pos = strrpos($footer, 'nav nav-justified');
        $footer = substr($footer, 0, $pos);
        $find = strrpos($return, $footer);
        $this->assertTrue($find != false);

        //Content
        $find = strrpos($return, $content);
        $this->assertTrue($find != false);

        unset($ResponseObj);

        /** 
         *
         *  Test the third condition in render()
         *
         */
        $ResponseObj = new Response;

        $content = 'Test content';
        $ResponseObj->setContent($content);
        $return = $ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $return = $ResponseObj->render();
        
        //Content
        $find = strrpos($return, $content);
        $this->assertTrue($find == 0);

        unset($ResponseObj);
    }

    function testSend()
    {
        
    }

  }
?>


