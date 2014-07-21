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
        unset($this->ResponseObj);
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
        $this->assertTrue($return == $content.$appContent);
    }

    function testRender()
    {
        $ResponseObj = new Response;

        $theme = new erdiko\core\Theme('bootstrap', null, 'default');
        $ResponseObj->setTheme($theme);
        $return = $ResponseObj->getTheme();
        $this->assertTrue($return == $theme);

        //Add some content
        $content = 'Here are some content';
        $ResponseObj->setContent($content);
        $return = $ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $return = $ResponseObj->render();
        
        
        /** 
         *  Compare header, content, and footer
         *
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
         *  Test the second condition
         *
         */
        $ResponseObj = new Response;
        

        $ResponseObj->setThemeName('bootstrap');
        $return = $ResponseObj->getTheme();
        
        //Add some content
        $content = 'Here are some content';
        $ResponseObj->setContent($content);
        $return = $ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $return = $ResponseObj->render();
        
        /** 
         *  Compare header, content, and footer
         *
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
         *  Test the third condition
         *
         */
        $ResponseObj = new Response;

        $content = 'Here are some content';
        $ResponseObj->setContent($content);
        $return = $ResponseObj->getContent();
        $this->assertTrue($return == $content);

        $return = $ResponseObj->render();
        
        //Content
        echo $return;
        $find = strrpos($return, $content);
        $this->assertTrue($find == 0);

        unset($ResponseObj);
    }

    function testSend()
    {
        
    }

  }
?>


