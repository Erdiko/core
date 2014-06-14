<?php
/**
 * Theme Interface
 * Base Theme interface, All themes must implement this interface.
 * 
 * @category   Erdiko
 * @package    Interfaces
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\interfaces;

interface Theme
{
	public function getHeader($name = "");
	public function getFooter($name = "");
	public function getMainContent($name = "", $options = null);
	public function getSidebar($name, $options = null);
	public function getLayout();
}
