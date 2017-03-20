<?php
/**
 * Controller
 * Base request handler, All controllers should be a child this class
 * or one of the subclasses (e.g. controllers/Ajax or controllers/Api)
 *
 * @package     erdiko
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko;

use Interop\Container\ContainerInterface;


class Controller
{
    protected $container;
   
    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
    }

    /**
     * Redirect to another url
     * @param string $url
     */
    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}