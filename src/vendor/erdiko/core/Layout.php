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
    protected $_data = array();
    protected $_theme;
    

    /**
     * Constructor
     * @param string $template, Theme Object (Contaier)
     * @param mixed $data
     */
    public function __construct($template = null, $data = null, $theme = null)
    {
        $template = ($template === null) ? $this->_defaultTemplate : $template;
        $this->setTemplate($template);
        $this->setData($data);
        $this->setTheme($theme);
    }

    public function getTemplateFile($filename, $data)
    {
        // @todo array merge regions with data
        // Push the data into regions and then pass a pointer to this class to the layout
        $this->setRegions($data);
        return parent::getTemplateFile($filename, $this); // Pass in layout object to template
    }

    public function setTheme($theme)
    {
        $this->_theme = $theme;
        $this->_templateFolder = 'themes/'.$theme.'/templates/layouts';
    }

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
     * Set all regions at once
     * 
     * @param array $data, associative array of containers/strings
     */
    public function setRegions($data)
    {
        $this->_regions = $data;
    }

    /**
     * get rendered region
     *
     * @param string $name
     * @return mixed $content, typically a string, Container object or other object
     */
    public function getRegion($name)
    {
        $html = (is_subclass_of($this->_regions[$name], 'erdiko\core\Container')) ? $this->_regions[$name]->toHtml() : $this->_regions[$name];

        return $html;
    }

}