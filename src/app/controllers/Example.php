<?php
/**
 * Examples Controller
 * Multiple examples of how you can use erdiko.  It includes some simple use cases.
 *
 * @category 	app
 * @package   	Example
 * @copyright	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace app\controllers;

use Erdiko;
use erdiko\core\Config;

class Example extends \erdiko\core\Controller
{
	

	public function _before()
	{
		$this->setThemeName('bootstrap');
	}

	public function getHello()
	{
		$this->setTitle('Hello World');
		$this->setContent("Hello World");
	}

	public function get($var = null)
	{
		if($var != null)
		{
			// load action
			return $this->autoaction($var);
		}

		$m = new \Mustache_Engine;
		$test = $m->render('Hello, {{ planet }}!', array('planet' => 'world')); // Hello, world!

		// error_log("mustache = {$test}");
		// error_log("var: ".print_r($var, true));

		$data = array("hello", "world");
		$view = new \erdiko\core\View('hello/world', $data);
		
		$this->setContent($view);
	}

	/**
	 * Homepage Action (index)
	 * @params array $arguments
	 */
	public function getIndex()
	{
		// Add page data
		$this->setTitle('Examples');
		$this->setView('examples/index');
	}

	public function getBaseline()
	{
		$this->setContent( "The simplest page possible" );
	}

	public function getFullpage()
	{
		$this->setThemeTemplate('fullpage');
		$this->setContent( "This is a fullpage layout (sans header/footer)" );
	}

	public function getSetview()
	{
		$this->setTitle('Example: Page with a single view');
		$this->setView('examples/setview');
	}

	public function getSetmultipleviews()
	{
		$this->setTitle('Example: Page with multiple views');

		// Include multiple views directly
		$content = $this->getView('examples/one');
		$content .= $this->getView('examples/two');
		$content .= $this->getView('examples/three');

		$this->setContent( $content );
	}

	public function getSetmultipleviewsAlt()
	{
		$this->setTitle('Example: Page with multiple views (alt)');

		// Add multiple views using api
		$this->addView('examples/one');
		$this->addView('examples/two');
		$this->addView('examples/three');
	}

	public function getSetview2()
	{
		// Include multiple views indirectly 
		$page = array(
			'content' => array(
				'view1' => $this->getView('examples/one'),
				'view2' => $this->getView('examples/two'),
				'view3' => $this->getView('examples/three')
				)
			);
		
		$this->setTitle('Example: Multiple views take 2');		
		$this->setView('examples/setview2', $page);
	}




	public function twocolumnAction()
	{
		$this->setLayoutColumns(3);
		
		$right = $this->getView(null, 'examples/one.php');
		$right .= $this->getView(null, 'examples/two.php');
		$right .= $this->getView(null, 'examples/three.php');

		// Set sidebars directly
		$sidebars = array(
			'right' => array(
				'content' => $right,
				'view' => 'sidebars/default.php')
			);
		$this->setSidebars($sidebars);

		$this->setBodyContent( '2 column layout example' );
		$this->setTitle('2 Column Page');
		$this->setPageTitle( 'Example: Complex 2 Column' );
	}

	public function threecolumnAction()
	{
		$this->setLayoutColumns(3);
		
		$left = $this->getView(null, 'examples/one.php');
		$left .= $this->getView(null, 'examples/two.php');
		$left .= $this->getView(null, 'examples/three.php');

		// Set sidebars directly
		$sidebars = array(
			'left' => array('content' => $left),
			'right' => array(
				'content' => 'right sidebar',
				'view' => 'sidebars/default.php')
			);
		$this->setSidebars($sidebars);

		$this->setBodyContent( '3 column layout example' );

		$this->setTitle('3 Column Page');
		$this->setPageTitle( 'Example: Complex 3 Column' );
	}

	/**
	 * Slideshow Action 
	 * @params array $arguments
	 */
	public function carouselAction()
	{
		// Add page data
		$this->setTitle('Carousel');
		$this->setView('pages/carousel.php');

		// Add Extra js
		$this->addJs('/themes/bootstrap/js/carousel.js');
	}

	public function phpinfoAction()
	{
		phpinfo();
		exit;
		
		// Add page data
		$this->setTitle('PHP Info');
		$this->setBodyContent("booyah");
	}

	public function dataAction()
	{
		// Include multiple views indirectly (and page title)
		$page = array(
			'content' => array(
				'view1' => $this->getView(null, 'examples/one.php'),
				'view2' => $this->getView(null, 'examples/two.php'),
				'view3' => $this->getView(null, 'examples/three.php')
				),
			'title' => 'Example: Page with multiple views'
			);

		$this->setData($page);
		$this->setTitle('This is the title in the browser tab');		
		$this->setView('examples/setview2.php');
	}
}