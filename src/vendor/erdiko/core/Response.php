<?php
/**
 * Response
 * base response, all response objects should inherit from here
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;


class Response
{
	protected $_theme;
	protected $_content = null;
	
	/**
	 * Constructor
	 * @param Theme $theme, Theme Object (Contaier)
	 */
	public function __construct($theme = null)
	{
		$this->_theme = $theme;
    }

    /**
     * @param Theme $theme, Theme Object (Container)
     */
    public function setTheme($theme)
    {
    	$this->_theme = $theme;
    }

    /**
     * @param Container $content, e.g. View or Layout Object
     */
    public function setContent($content)
    {
    	$this->_content = $content;
    }

    public function render()
    {
        $content = (is_subclass_of($this->_content, 'erdiko\Container')) ? $content->toHtml() : $this->_content;

        if($this->_theme !== null)
            $html = $this->_theme->render($content);
        else
            $html = $content;

        return $html;
    }

}
