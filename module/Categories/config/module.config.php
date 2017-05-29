<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Categories;

return array(
    'router' => array(
        'routes' => array(
            'category' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/category/index',
                    'defaults' => array(
                        'controller' => 'Categories\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'categorylist' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/categorylist',
                    'defaults' => array(
                        'controller' => 'Categories\Controller\Index',
                        'action' => 'categorylist',
                    ),
                ),
            ),
            'deletecategory' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/deletecategory',
                    'defaults' => array(
                        'controller' => 'Categories\Controller\Index',
                        'action' => 'deletecategory',
                    ),
                ),
            ),
            'addcategory' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/addcategory',
                    'defaults' => array(
                        'controller' => 'Categories\Controller\Index',
                        'action' => 'addcategory',
                    ),
                ),
            ),
            'updatecategory' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/updatecategory[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Categories\Controller\Index',
                        'action' => 'updatecategory',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
        'aliases' => array(
            'categoryModel' => 'Categories\Model\Categories',
        ),
        'invokables' => array(
            'Categories\Model\Categories' => 'Categories\Model\Categories',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Categories\Controller\Index' => Controller\IndexController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'categories/index/index' => __DIR__ . '/../view/categories/index/index.phtml',
            //'error/404'               => __DIR__ . '/../view/error/404.phtml',
            //'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
