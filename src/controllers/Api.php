<?php
/**
 * Api Controller
 *
 * @package     erdiko/controllers
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\controllers;


class Api extends \erdiko\Controller
{

  /**
   * Contructor
   */
    public function __construct()
    {
        $this->_webroot = ERDIKO_ROOT;
        $this->_response = new \erdiko\core\ApiResponse;
    }

  /**
   * setStatusCode
   *
   */
    public function setStatusCode($code = null)
    {
        if (!empty($code)) {
            $this->_response->setStatusCode($code);
        }
    }

    public function setErrors($errors = null)
    {
        if (!empty($errors)) {
            $this->_response->setErrors($errors);
        }
    }
}
