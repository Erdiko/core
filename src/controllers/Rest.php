<?php
/**
 * REST Controller
 * Simple convention based REST controller to auto route controllers & actions
 *
 * @package     erdiko/controllers
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\controllers;


class Rest extends \erdiko\Controller
{
    protected function determineAction($request, $args = null)
    {
        $action = strtolower($request->getMethod());
        $this->container->logger->debug("action: {$action}");
        $this->container->logger->debug("args: ".print_r($args, true));
    }
}
