<?php

namespace Demoapplication\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

abstract class DemoapplicationAbstractActionController extends AbstractActionController
{
    
    const USER_DATA_SESSION_KEY = 'userData';

    /**
     * Overriding:: Execute the request
     *
     * @param  MvcEvent $e
     * @return mixed
     * @throws DomainException
     */
    public function onDispatch(MvcEvent $e){
        
        $routeMatch = $e->getRouteMatch();
        if (!$routeMatch) {
            /**
             * @todo Determine requirements for when route match is missing.
             *       Potentially allow pulling directly from request metadata?
             */
            throw new Exception\DomainException('Missing route matches; unsure how to retrieve action');
        }
        
        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);
        
        if (!method_exists($this, $method)) {
            $method = 'notFoundAction';
        }
        
        $actionResponse = $this->$method();
        
        $e->setResult($actionResponse);
        
        return $actionResponse;
    }
    
    /**
     * 
     * @return 
     */
    public function getResourceManager()
    {
        return $this->getServiceLocator()->get('resourceManager');
    }
    
}

