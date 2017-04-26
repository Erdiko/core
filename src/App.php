<?php
/**
 * Erdiko Helper
 *
 * Some global helpers
 *
 * @package     erdiko\core
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko;


class App extends \Slim\App
{
    /**
     * Create new application
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an associative array of app settings
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container = null)
    {
        if($container == null) {
            $container = require ERDIKO_ROOT."/contexts/".
                getenv('ERDIKO_CONTEXT')."/bootstrap/settings.php";
        }
        parent::__construct($container);
    }
}