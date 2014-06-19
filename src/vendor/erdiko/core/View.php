<?php
/**
 * Container
 * Base view layer object
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;


class View extends Container
{	
	protected $_templateFolder = 'views';

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
    	$this->_template = $template;
    }

    /**
     * @param Container $content, e.g. View or Layout Object
     */
    public function setContent($content)
    {
    	$this->_content = $content;
    }

    /**
     * @param mixed $data, data injected into the view
     */
    public function setData($data)
    {
        $this->_data = $data;
    }
}