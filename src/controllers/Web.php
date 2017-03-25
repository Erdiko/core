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
    public function __invoke($request, $response, $args) 
    {
        $action = $this->determineAction($request, $args);
        $this->container->logger->debug("Controller action: ".print_r($action, true));

        $this->$action($request, $response, $args); 
    }
    
    protected function determineAction(&$request, &$args) : string
    {
        // REQUEST_METHOD
        $action = strtolower($request->getMethod());
        // Action
        $action .= ucfirst($args['action']);

         // @todo trigger 404 instead of throw exception
        if(!method_exists($this, $action))
            throw new \Exception("action does not exist");

        return $action;
    }
}
