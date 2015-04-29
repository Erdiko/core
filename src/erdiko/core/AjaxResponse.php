<?php
/**
 * AjaxResponse
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * 
 * @author	   John Arroyo john@arroyolabs.com
 * @author	   Andy Armstrong andy@arroyolabs.com
 */
namespace erdiko\core;
use Erdiko;

/**
 * AjaxResponse class
 */
class AjaxResponse extends Response 
{

    /**
     * _statusCode
     *
     * Unless explicitly set, default to a 200 status 
     * assuming everything went ok.
     */
    protected $_statusCode = 200;

    /**
     * Theme
     */
    protected $_theme;

    /**
     * Content
     */
    protected $_content = null;

    /**
     * setStatusCode
     * 
     * Set, and send, the HTTP status code. 
     */
    public function setStatusCode($code = null) {
      if(!empty($code)) {
        $this->_statusCode = $code;
        http_response_code($this->_statusCode); // this sends the http status code
      }
    }

    /**
     * Ajax render function
     *
     * @return string
     */
    public function render()
    {
      $responseData = array(
                              "status" => $this->_statusCode,
                              "body" => $this->_content,
                              "errors" => array()
                            );

      return json_encode($responseData);
    }

}
