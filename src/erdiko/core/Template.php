<?php
/**
 * Template trait
 * A consistent way to render a template for all theme/view classes
 *
 * By including this trait in your class, your object can act like a view (like magic)
 *
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2016, Arroyo Labs, http://www.arroyolabs.com
 * @author     John Arroyo
 */
namespace erdiko\core;


trait Template
{
    /** Template */
    protected $_template = null;
    /** Data */
    protected $_data = null;
    /** Default Template */
    protected $_defaultTemplate = 'default';
    /** Default Template Root Folder */
    protected $_templateRootFolder = null;
    /** Template Folder */
    protected $_templateFolder = null;

    /**
     * Constructor like initiation
     * @param string $template , Theme Object (Contaier)
     * @param mixed $data
     */
    public function initiate($template = null, $data = null, $templateRootFolder = APPROOT)
    {
        $template = ($template === null) ? $this->getDefaultTemplate() : $template;
        $this->setTemplate($template);
        $this->setData($data);
        $this->setTemplateRootFolder($templateRootFolder);
    }

    /**
     * Set template
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * Get template
     *
     * @param string $template
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Get default template name
     *
     * @param string $template
     */
    public function getDefaultTemplate()
    {
        return $this->_defaultTemplate;
    }

    /**
     * Set default template name
     *
     * @param string $template
     */
    public function setDefaultTemplate($template)
    {
        $this->_defaultTemplate = $template;
    }

    /**
     * Set template root folder
     *
     * @param string $TemplateRootFolder
     */
    public function setTemplateRootFolder($templateRootFolder)
    {
        $this->_templateRootFolder = $templateRootFolder;
    }

    /**
     * Set data
     *
     * @param mixed $data , data injected into the container
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * Get data
     *
     * @return mixed $data , data injected into the container
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get Template folder
     */
    public function getTemplateFolder()
    {
        return $this->_templateRootFolder.'/'.$this->_templateFolder.'/';
    }

    /**
     * Set Template folder
     */
    public function setTemplateFolder($templateFolder)
    {
        $this->_templateFolder = $templateFolder;
    }

    /**
     * Get rendered template file
     * Accepts one of the types of template files in this order:
     * php (.php), html/mustache (.html), markdown (.md)
     *
     * @param string $filename , file without extension
     * @param array $data , associative array of data
     * @throws \Exception , template file does not exist
     */
    public function getTemplateFile($filename, $data)
    {
        if (is_file($filename.'.php')) {
            ob_start();
            include $filename.'.php';
            return ob_get_clean();

        } elseif (is_file($filename.'.html')) {
            $file = file_get_contents($filename.'.html');
            $m = new \Mustache_Engine;
            return $m->render($file, $data);

        } elseif (is_file($filename.'.md')) {
            $parsedown = new \Parsedown();
            return $parsedown->text(file_get_contents($filename.'.md'));
        }

        throw new \Exception("Template file does not exist ({$filename})");
    }

    /**
     * Render container to HTML
     *
     * @return string $html
     */
    public function toHtml()
    {
        $filename = $this->getTemplateFolder().$this->getTemplate();
        $data = (is_subclass_of($this->_data, 'erdiko\core\Container')) ? $this->_data->toHtml() : $this->_data;

        return $this->getTemplateFile($filename, $data);
    }
}
