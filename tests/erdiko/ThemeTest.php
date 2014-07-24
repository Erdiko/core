<?php

use erdiko\core\Theme;
require_once dirname(__DIR__).'/ErdikoTestCase.php';


class ThemeTest extends ErdikoTestCase
{
    var $themeObj = null;

    function setUp()
    {
        $this->themeObj = new \erdiko\core\Theme;
        $this->themeObj->setName('bootstrap');
    }

    function tearDown() {
        unset($this->themeObj);
    }

    function testSetNameAndGetName()
    {
        $this->themeObj->setName('bootstrap');
        $return = $this->themeObj->getName();
        $this->assertEquals($return, 'bootstrap');
    }

    function testGetConfig()
    {
        $this->themeObj->setName('bootstrap');
        $return = $this->themeObj->getConfig();

        $config = file_get_contents($this->themeObj->getThemeFolder().'theme.json');
        $return2 = json_decode($config, true);
        $this->assertEquals($return, $return2);
    }

    function testAddMetaAndGetMeta()
    {
        $temp = array();
        $temp[] = array(
                'name' => 'Test_Name',
                'content' => 'Test_Content'
                );
        $this->themeObj->addMeta('Test_Name', 'Test_Content');
        $return = $this->themeObj->getMeta();
        $this->assertEquals($return, $temp);
    }

    function testAddCssAndGetCss()
    {
        $temp = array();
        $temp[] = array(
                'file' => 'Test_Css_File',
                'active' => '1'
                );
        $this->themeObj->addCss('Test_Css_File');
        $return = $this->themeObj->getCss();
        $this->assertEquals($return, $temp);
    }

    function testAddJsAndGetJs()
    {
        $temp = array();
        $temp[] = array(
                'file' => 'Test_Js_File',
                'active' => '1'
                );
        $this->themeObj->addJs('Test_Js_File');
        $return = $this->themeObj->getJs();
        $this->assertEquals($return, $temp);
    }

    function testGetPageTitle()
    {
        $page_title = 'Test_Page_Title';
        $temp = array(
                'page_title' => $page_title,
                );
        $this->themeObj->setData($temp);
        $return = $this->themeObj->getPageTitle();
        $this->assertEquals($return, $page_title);
    }

    function testGetBodyTitle()
    {
        $body_title = 'Test_Body_Title';
        $temp = array(
                'body_title' => $body_title,
                );
        $this->themeObj->setData($temp);
        $return = $this->themeObj->getBodyTitle();
        $this->assertEquals($return, $body_title);
    }

    function testGetThemeFolder()
    {
        $return = $this->themeObj->getThemeFolder();
        $this->assertEquals($return, '/Users/ColemanTung/ArroyoLabs/erdiko-core/src/app/themes/bootstrap/');
    }

    function testGetTemplateFolder()
    {
        $return = $this->themeObj->getTemplateFolder();
        $this->assertEquals($return, '/Users/ColemanTung/ArroyoLabs/erdiko-core/src/app/themes/bootstrap/templates/');
    }

    function testSetContentAndGetContent()
    {
        $content = 'It is some content';
        $this->themeObj->setContent($content);
        $return = $this->themeObj->getContent();
        $this->assertEquals($return, $content);
    }

    function testSetTemplate()
    {
        $template = 'test_template';
        $this->themeObj->setTemplate($template);
        $return = $this->themeObj->getTemplate();
        $this->assertEquals($template, $return);
    }

    function testSetNameNGetName()
    {
        $name = "Test_Name";
        $this->themeObj->setName($name);
        $return = $this->themeObj->getName();
        $this->assertEquals($name, $return);
    }

    function testGetContextConfig()
    {
        $return = $this->themeObj->getContextConfig();
        $this->assertArrayHasKey('site', $return);
        $this->assertArrayHasKey('theme', $return);
        $this->assertArrayHasKey('layout', $return);
    }

    function testGetTemplateHtml()
    {
        $return = $this->themeObj->getTemplateHtml('header');

        $header = file_get_contents($this->themeObj->getTemplateFolder().'/page/header.php');
        $pos = strrpos($header, 'navbar-brand');
        $header = substr($header, 0, $pos);
        $find = strrpos($return, $header);
        $this->assertTrue($find !== false);
    }

    function testToHtml()
    {

        $content = 'It is some content';
        $data = 'It is some data';
        $this->themeObj->addMeta('Test_Name', 'Test_Content');
        $return = $this->themeObj->toHtml($content, $data);

        //Check header
        $header = file_get_contents($this->themeObj->getTemplateFolder().'/page/header.php');
        $pos = strrpos($header, 'navbar-brand');
        $header = substr($header, 0, $pos);
        $find = strrpos($return, $header);
        $this->assertTrue($find !== false);

        //Check content
        $pos = strrpos($header, $content);
        $this->assertTrue($find !== false);

        //Check data
        $pos = strrpos($header, $data);
        $this->assertTrue($find !== false);
    }


  }
?>