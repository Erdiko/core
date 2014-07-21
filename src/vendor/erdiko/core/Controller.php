<?php
/**
 * Controller
 * Base request handler, All controllers should inherit this class.
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;


class Controller 
{
	protected $_response;
	protected $_webroot;
	protected $_themeName = null;
	protected $_theme = null;

	
	public function __construct()
	{
		$this->_webroot = ROOT;
		$this->_response = new \erdiko\core\Response;

		if($this->_themeName != null)
			$this->_response->setTheme($this->_themeName);
    }

    /**
     * Set the theme name in the response
     * @param string $name, the name/id of the theme
     */
    public function setThemeName($name)
    {
    	$this->getResponse()->setThemeName($name);
    }

    /**
     * Get the theme name
     * 
     * @return string $name
     */
    public function getThemeName()
    {
    	return $this->getResponse()->getThemeName();
    }

    /**
     * Set the theme template used to render the page
     * @param string $template 
     */
    public function setThemeTemplate($template)
    {
    	$this->getResponse()->setThemeTemplate($template);
    }

    /**
	 * Before action hook
	 * Anything here gets called immediately BEFORE the Action method runs.
	 */
	public function _before()
	{
		// do something...
	}

	/**
	 * After action hook
	 * anything here gets called immediately AFTER the Action method runs.
	 */
	public function _after()
	{
		// do something...
	}

    public function getResponse()
    {
    	return $this->_response;
    }

    final public function send()
    {
    	echo $this->getResponse()->render();
    }

    public function setResponseDataValue($key, $value)
    {
    	$this->getResponse()->setDataValue($key, $value);
    }

	/**
	 * Add page title text to current page
	 */
	public function setPageTitle($title)
	{
		$this->setResponseDataValue('page_title', $title);
	}

	/**
	 * Set page content title to be themed in the view
	 *
	 * @param string $title
	 */
	public function setBodyTitle($title)
	{
		$this->setResponseDataValue('body_title', $title);
	}

	/**
	 * Set both the title (header) and page title (body) at the same time
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->setPageTitle($title);
		$this->setBodyTitle($title);
	}

	/**
	 * Set the response content
	 */
	public function setContent($content)
	{
		$this->getResponse()->setContent($content);
	}

	/**
	 * Add/append html text to the response content
	 */
	public function appendContent($content)
	{
		$this->getResponse()->appendContent($content);
	}

	/**
	 *
	 */
	protected function _autoaction($var, $httpMethod = 'get')
	{
		// error_log("httpMethod: $httpMethod");
		$method = $this->urlToActionName($var, $httpMethod);
		if(method_exists($this, $method))
			return $this->$method();
		else
			\ToroHook::fire('404');
	}

	/**
     * Call back for preg_replace in urlToActionName
     */
    private function _replaceActionName($parts) 
    {
        return strtoupper($parts[1]);
    }

    /**
     * Modify the action name coming from the URL into proper action name
     * @param string $name: The raw controller action name
     * @return string
     */
    public function urlToActionName($name, $httpMethod)
    {
        // convert to camelcase if there are dashes
        $function = preg_replace_callback("/\-(.)/", array($this, '_replaceActionName'), $name);

		return $httpMethod.ucfirst($function);
    }

    /**
	 * Set the view template to be used
	 *
	 * @param string $view, view file
	 */
	public function setView($view, $data = null)
	{
		$view = new \erdiko\core\View($view, $data);
		$this->setContent($view->toHtml());
	}
	
	/**
	 * Load a view with the given data
	 * 
	 * @param string $viewName
	 * @param array $data
	 * @return string $html, view contents
	 */
	public function getView($viewName, $data = null)
	{
		$view = new \erdiko\core\View($viewName, $data);
		return  $view->toHtml();
	}

	/**
	 * Add a view from the current theme with the given data
	 * 
	 * @param string $viewName
	 * @param array $data
	 * @return string $html, view contents
	 */
	public function addView($viewName, $data = null)
	{
		$view = new \erdiko\core\View($viewName, $data);
		$this->appendContent($view->toHtml());
	}

	/**
	 * Load a layout with the given data
	 * 
	 * @param string $layoutName
	 * @param array $data
	 * @return string $html, layout contents
	 */
	public function getLayout($layoutName, $data = null)
	{
		$layout = new \erdiko\core\Layout($layoutName, $data, $this->getThemeName());
		return  $layout->toHtml();
	}

	/**
	 * Redirect to another url
	 * @param string $url
	 */
	public function redirect($url)
	{
		header( "Location: $url" );
		exit;
	}


	/**
	 * 
	 * 
	 * 
	 *  Code below are deprecated or may need to be moved!
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 */





	/**
	 * @param string $arguments
	 * @return array $arguments
	 */
	public function parseArguments($arguments)
	{
		$arguments = explode("/", $arguments);
		return $arguments;
	}

	/**
	 * @param array $intArray
	 * @return array $keyArray
	 */
	public function compileNameValue($intArray)
	{
		$keyArray = array();
		for($i = 0; $i < count($intArray); $i += 2)
		{
			$keyArray[$intArray[$i]] = $intArray[$i+1];
		}
		return $keyArray;
	}

    /**
     * Add phpToJs variable to be set on the current page
     */
    public function addPhpToJs($key, $value)
    {
        if(is_bool($value)) {
            $value = $value ? "true" : "false";
        }elseif(is_string($value)) {
            $value = "\"$value\"";
        }elseif(is_array($value)) {
            $value = json_encode($value);
        }elseif(is_object($value) && method_exists($value, "toArray")) {
            $value = json_encode($value->toArray());
        }else{
            throw new \Exception("Can not translate a parameter from PHP to JS\n".print_r($value,true));
        }

        $this->_themeExtras['phpToJs'][$key] = $value;
    }
	
	/**
	 * Add Meta Tags to the page
	 * 
	 * @param string $content
	 * @param string $name, html meta name (e.g. 'description' or 'keywords')
	 */
	public function addMeta($content, $name = 'description')
	{
		$this->_themeExtras['meta'][$name] = $content;
	}



	/**
	 * 
	 */
	public function getExceptionHtml($message)
	{
		return "<div class=\"exception\">$message</div>";
	}
}
