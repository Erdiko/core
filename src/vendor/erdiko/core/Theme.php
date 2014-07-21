<?php
/**
 * Theme
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;

class Theme extends Container
{	
	protected $_templateFolder = 'themes';
    protected $_name = null;
    protected $_defaultName = 'default';
    protected $_config = null;
    protected $_content = null;
    protected $_extraCss = array();
    protected $_extraJs = array();
    protected $_extraMeta = array();


    /**
     * Constructor
     * @param string $template, Theme Object (Contaier)
     * @param mixed $data
     */
    public function __construct($name = null, $data = null, $template = 'default')
    {
        $name = ($name === null) ? $this->_defaultName : $name;
        $this->setName($name);
        $this->setData($data);
        $this->_template = $template; // this template is the page wrapper
    }

    /**
     *
     */
    public function getConfig()
    {
        if(empty($this->config))
        {
            $file = $this->getThemeFolder() . 'theme.json';
            $this->_config = Erdiko::getConfigFile($file);
        }
        return $this->_config;
    }

    /**
     *
     */
    public function getMeta()
    {
        //return array_merge($this->_data['meta'], $this->_extraMeta);
        
        if(isset($this->_data['meta']))
            return array_merge($this->_data['meta'], $this->_extraMeta);
        else 
            return $this->_extraMeta;

        /*
        if(isset($this->_data['meta']))
            return $this->_data['meta'];
        else 
            return array();
        */
    }

    /**
     * Add meta file to page
     *
     * @param string $metaName and $metaContent
     */
    public function addMeta($name, $content)
    {
        $this->_extraMeta[] = array(
            'name' => $name,
            "content" => $content
            );
    }

    /**
     *  @return string $page_title
     */
    public function getPageTitle()
    {
        if(isset($this->_data['page_title']))
            return $this->_data['page_title'];
        else 
            return null;
    }

    /**
     *  @return string $body_title
     */
    public function getBodyTitle()
    {
        if(isset($this->_data['body_title']))
            return $this->_data['body_title'];
        else 
            return null;
    }

    /**
     * get array of css files to include in theme
     *
     * @return array $css
     */
    public function getCss()
    {
        if(isset($this->_config['css']))
            return array_merge($this->_config['css'], $this->_extraCss);
        else
            return $this->_extraCss;
    }

    /**
     * Add css file to page
     * @param string $cssFile, uri of injected css file
     */
    public function addCss($cssFile)
    {
        $this->_extraCss[] = array(
            'file' => $cssFile,
            "active" => 1
            );
    }

    /**$this->_extraCss
     * Get array of js files to include
     * 
     * @return array $js
     */
    public function getJs()
    {
        if(isset($this->_config['js']))
            return array_merge($this->_config['js'], $this->_extraJs);
        else
            return $this->_extraJs;
    }

    /**
     * Add js file to page
     *
     * @param string $jsFile, link to js file
     */
    public function addJs($jsFile)
    {
        $this->_extraJs[] = array(
            'file' => $jsFile,
            "active" => 1
            );
    }

    /**
     * Get the theme folder
     * @return string $folder
     */
    public function getThemeFolder()
    {
        return parent::getTemplateFolder().$this->_name.'/';
    }

    /**
     * Get template folder relative to the theme root
     */
    public function getTemplateFolder()
    {
        return $this->getThemeFolder().'templates/';
    }


    /**
     * @param Container $content, e.g. View or Layout Object???
     */
    public function setContent($content)
    {
    	$this->_content = $content;
    }

    /**
     * @return string $content???
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * Set the theme name, the name is also the id of the theme
     * @param string $name, Theme name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get template file populated by the config
     * e.g. get header/footer
     * @return string $html
     */
    public function getTemplateHtml($partial, $context = 'default')
    {
        $config = $this->getConfig();
        $filename = $this->getTemplateFolder().$config['templates'][$partial]['file'];
        $html = $this->getTemplateFile($filename, $this->getContextConfig($context));
        
        return $html;
    }

    /**
     *
     */
    public function getContextConfig($context = 'default')
    {
        return Erdiko::getConfig('application/'.$context);
    }

    /**
     *
     */
    public function toHtml($content, $data)
    {
        $this->setContent($content); // rendered html (body content)
        $this->setData($data); // data injected from Response/Controller
        $this->getConfig(); // load the site config

        $filename = $this->getTemplateFolder().$this->_template;
        // error_log("theme filename: $filename");
        $html = $this->getTemplateFile($filename, $this);

        return $html;
    }
}