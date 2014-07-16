<?php
/**
 * AjaxResponse
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;


class AjaxResponse extends Response 
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

    }

    public function send()
    {
    	echo $this->render();
    }

}
