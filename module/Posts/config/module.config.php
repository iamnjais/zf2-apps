<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Posts;

return array(
    'router' => array(
        'routes' => array(
            'posts' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/posts/index',
                    'defaults' => array(
                        'controller' => 'Posts\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'postlist' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/postlist',
                    'defaults' => array(
                        'controller' => 'Posts\Controller\Index',
                        'action' => 'postlist',
                    ),
                ),
            ),
            'deletepost' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/deletepost',
                    'defaults' => array(
                        'controller' => 'Posts\Controller\Index',
                        'action' => 'deletepost',
                    ),
                ),
            ),
            'addpost' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/addpost',
                    'defaults' => array(
                        'controller' => 'Posts\Controller\Index',
                        'action' => 'addpost',
                    ),
                ),
            ),
            'updatepost' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/updatepost[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Posts\Controller\Index',
                        'action' => 'updatepost',
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
            'postModel' => 'Posts\Model\Posts',
        ),
        'invokables' => array(
            'Posts\Model\Posts' => 'Posts\Model\Posts',
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
            'Posts\Controller\Index' => Controller\IndexController::class
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
            'posts/index/index' => __DIR__ . '/../view/posts/index/index.phtml',
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
