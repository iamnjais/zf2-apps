<?php

namespace Demoapplication\Mvc\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CexAbstractModel
 *
 * @author naveen.jaiswal
 */
abstract class DemoapplicationAbstractModel  implements ServiceLocatorAwareInterface{

    /**
     *
     * @var dbAdapter 
     */
    protected $dbAdapter;
    
    /**
     *
     * @var ServiceLocatorInterface 
     */
    protected $serviceLocator;

    /**
     * @var 
     */
    private $resourceManager;

    /**
     * 
     * @return type
     */
    public function getDBAdapter() {
        
        if (!$this->dbAdapter) {
            $sm = $this->getServiceLocator();
            $this->dbAdapter = $sm->get('db');
        }
        return $this->dbAdapter;
    }
    
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * 
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * 
     * @return type
     */
    public function getResourceManager()
    {
        if (null === $this->resourceManager) {
            $this->resourceManager = $this->serviceLocator->get('resourceManager');
        }

        return $this->resourceManager;
    }

}
