<?php

use Zend\Loader\StandardAutoloader;
use Zend\Mvc\Application;
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';

$loader = new StandardAutoloader();
$loader->registerNamespace('Demoapplication', realpath('vendor/Demoapplication/library/Demoapplication'));
$loader->register();

// Run the application!
Application::init(require 'config/application.config.php')->run();
