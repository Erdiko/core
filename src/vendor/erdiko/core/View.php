<?php
/**
 * View
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
     * @param Container $content, e.g. View or Layout Object
     */
    public function setContent($content)
    {
    	$this->_content = $content;
    }
}