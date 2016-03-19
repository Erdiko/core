<?php
/**
 * View
 *
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2016, Arroyo Labs, http://www.arroyolabs.com
 * @author     John Arroyo
 */
namespace erdiko\core;

/** View Class */
class View extends Container
{
    /** Template Folder */
    protected $_templateFolder = 'views';
    protected $_config = null;

    /**
     * Get a view, for nesting views
     * This is a convenience wrapper for inherited getTemplateFile() method
     * Note: expects this sub view to be in the same views folder (or nested below this folder relative to views/)
     */
    public function getView($filename, $data)
    {
        return $this->getTemplateFile($this->getTemplateFolder().$filename, $data);
    }
}
