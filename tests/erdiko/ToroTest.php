<?php
/**
 * Example of how to set up a unit test
 * Test the functionality of the Erdiko framework static methods
 */
namespace tests\erdiko;

require_once dirname(__DIR__).'/ErdikoTestCase.php';

class ToroTest extends \tests\ErdikoTestCase
{
    public function tearDown()
    {
        $webRoot = dirname(dirname(__DIR__));
        unset($this->fileObj);
    }

    public function testServe()
    {
        $routes = \Erdiko::getRoutes();
        $_SERVER['REQUEST_METHOD'] = 'get';

        ob_start();

        \erdiko\core\Toro::serve($routes);
        $out = ob_get_contents();

        ob_end_clean();

        // Check some content matches
        $this->assertEquals(1, preg_match('/<html/', $out));
        $this->assertEquals(1, preg_match('/<header/', $out));
        $this->assertEquals(1, preg_match('/<footer/', $out));
        $this->assertEquals(1, preg_match('/<\/html/', $out));

        /*
        //Remove header
        $pos = strrpos($out, "</header>");
        $out = substr($out, $pos+9);

        //Remove footer
        $pos = strrpos($out, '<footer id="footer">');
        $out = substr($out, 0, $pos);
        //var_dump($out);
        
        $header = file_get_contents($themeFolder.'/templates/page/header.php');
        $pos = strrpos($header, 'navbar-brand');
        $header = substr($header, 0, $pos);
        $find = strrpos($return, $header);
        $this->assertTrue($find != false);
        */
    }
}
