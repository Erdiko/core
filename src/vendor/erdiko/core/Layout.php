<?php
/**
 * Layout
 * @todo allow switching between layout templates in the theme and the views folder
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;


class Layout extends Container
{	
	protected $_templateFolder = 'themes';
    protected $_regions = array();

    /**
     * set region
     *
     * @param string $name
     * @param mixed $content, typically a string, Container object or other object
     */
    public function setRegion($name, $content)
    {
        $this->_regions[$name] = $content;
    }

    /**
     * get rendered region
     *
     * @param string $name
     * @return mixed $content, typically a string, Container object or other object
     */
    public function getRegion($name)
    {
        $html = (is_subclass_of($this->_regions[$name], 'erdiko\core\Container')) ? $this->_regions[$name]->toHtml() : $_regions[$name];

        return $html;
    }

}