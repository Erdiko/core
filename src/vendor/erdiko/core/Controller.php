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
	 *
	 */
	public function autoaction($var, $httpMethod = 'get')
	{
		$method = $this->urlToActionName($var, $httpMethod);
		return $this->$method();
	}

	/**
     * Call back for preg_replace in urlToActionName
     */
    public function _replaceActionName($parts) 
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
		$this->setContent($view);
	}
	







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
	 * Add js file to current page
	 */
	public function addJs($file)
	{
		$this->_themeExtras['js'][] = array(
			'file' => $file,
			'active' => 1);
	}
	
	/**
	 * Add Css file to current page
	 * @note Not yet supported
	 */
	public function addCss($file)
	{
		$this->_themeExtras['css'][] = array('file' => $file);
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
	 * Primary request router
	 *
	 * @param string $name, action name
	 * @param string $arguments remaining url params
	 */
	public function route($name, $arguments)
	{
		// Prepare arguments and name
		$arguments = $this->parseArguments($arguments);
		$splitName = $this->parseArguments($name);
		$ct = count($splitName);
		if($arguments == null)
			$arguments = array('raw_url_key' => $name);
		else
			$arguments = array_merge(array('raw_url_key' => $name), $arguments);

		// Check name for rest url components
		// @todo check for first arg after action name is an int, if so insert it as array("id" => [int])
		switch($ct) {
			case 0:
				$name = "index";
				break;
			case 1:
				$name = $splitName[0];
				break;
			default:
				$name = $splitName[0];
				$len = $ct-1;
				if( ($len % 2) > 0 )
					$nameArgs = array_slice($splitName, 1, $len);
				else
					$nameArgs = $this->compileNameValue(array_slice($splitName, 1, $len));
				$arguments = array_merge($nameArgs, $arguments);
				break;
		}
		
		// Get data to populate page wrapper
		$data = $this->_contextConfig['layout'];
		$this->_arguments = $arguments;
		
		// Load the page content
		try 
		{
            $action = $this->urlToActionName($name);
            $this->_before();

            // Determine what content should be called 
            if( empty($name) )
				$this->indexAction($arguments);
			else
				$this->$action($arguments); // run the action method of the handler/controller

			$this->_after();
		}
		catch(\Exception $e)
		{
			Erdiko::log($e->getMessage());
			$this->appendBodyContent( $this->getExceptionHtml( $e->getMessage() ) );
		}
		
		$this->theme($data);
	}

	/**
	 * Load a view from the current theme with the given data
	 * 
	 * @param string $file
	 * @param array $data
	 * 
	 * @todo deprecate this function -John 
	 * @todo render views with the theme engine instead
	 */
	public function getView($data = null, $file = null)
	{
		$filename = VIEWROOT.$file;
		return  Erdiko::getTemplate($filename, $data);
	}

    /**
	 * Add a page content data to be themed in the view
	 *
	 * @param mixed $data
     * @return $this: Provides chaining
	 */
	public function addContentData($key, $value)
	{
        if(empty($this->_pageData['data']['content'])) {
        	$this->_pageData['data']['content'] = array();
        }
        // If we have a scalar value setup then just return false(maybe throw an exception in future)
        if(!is_array($this->_pageData['data']['content'])) {
    		return false;
        }
        $this->_pageData['data']['content'][$key] = $value;
        return $this;
	}

	public function setLayoutColumns($cols)
	{
		$this->_numberColumns = $cols;
	}

	/**
	 * Set the view template to be used
	 *
	 * @param string $name
	 * @param mixed $content
	 * @param string $view, view filename
	 */
	public function setSidebar($name, $content, $view = null)
	{
		$this->_pageData['sidebar'][$name]['content'] = $content;
		if($view != null)
			$this->_pageData['sidebar'][$name]['view'] = $view;
	}

	/**
	 * Set the sidebars directly as array elements
	 * 
	 * @param array $data, array can have 'left' and 'right' indicies
	 */
	public function setSidebars($data)
	{
		$this->_pageData['sidebar'] = $data;
	}

	public function redirect($url)
	{
		header( "Location: $url" );
		exit;
	}

	public function getExceptionHtml($message)
	{
		return "<div class=\"exception\">$message</div>";
	}
}
