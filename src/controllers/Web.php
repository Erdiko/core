<?php
/**
 * Web Controller
 * Simple convention based web controller to auto route actions
 *
 * @package     erdiko/controllers
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\controllers;


class Web extends \erdiko\Controller
{
    protected function determineAction($request, $args = null)
    {
        // REQUEST_METHOD
        $action = strtolower($request->getMethod());
        $this->container->logger->debug("action: {$action}");
        $this->container->logger->debug("args: ".print_r($args, true));
    }
}
