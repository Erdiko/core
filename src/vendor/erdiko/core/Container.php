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


class Container
{
    protected $_template = null;
    protected $_data = null;
    protected $_defaultTemplate = 'default';
    protected $_templateFolder = null;

    /**
     * Constructor
     * @param string $template, Theme Object (Contaier)
     * @param mixed $data
     */
    public function __construct($template = null, $data = null)
    {
        $template = ($template === null) ? $this->_defaultTemplate : $template;
        $this->setTemplate($template);
        $this->setData($data);
    }
	
    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
    	$this->_template = $template.".php";
    }

    /**
     * @param mixed $data, data injected into the view
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    public function getTemplateFolder()
    {
        return APPROOT.'/'.$this->_templateFolder.'/';
    }

    public function getTemplateFile($filename, $data)
    {
        error_log("getTemplateFile($filename)");

        if (is_file($filename))
        {
            ob_start();
            include $filename;
            return ob_get_clean();
        }
        
        throw new \Exception("Template file does not exist");
    }

    public function toHtml()
    {
        $filename = $this->getTemplateFolder().$this->_template.'.php';
        $data = (is_subclass_of($this->_data, 'erdiko\core\Container')) ? $this->_data->toHtml() : $this->_data;

        error_log("filename: $filename");

        return $this->getTemplateFile($filename, $data);
    }
}
