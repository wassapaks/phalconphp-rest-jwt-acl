<?php

// use Phalcon\Di;
// use Phalcon\Di\FactoryDefault;
// use Phalcon\Loader;

// ini_set("display_errors", 1);
// error_reporting(E_ALL);

// define("ROOT_PATH", __DIR__);

// set_include_path(
//     ROOT_PATH . PATH_SEPARATOR . get_include_path()
// );

// // Required for phalcon/incubator
// include __DIR__ . "/../vendor/autoload.php";

// // Use the application autoloader to autoload the classes
// // Autoload the dependencies found in composer
// $loader = new Loader();

// $loader->registerDirs(
//     [
//         ROOT_PATH,
//     ]
// );

// $loader->register();

// $di = new FactoryDefault();

// Di::reset();

// // Add any needed services to the DI here

// Di::setDefault($di);


//-------------------------------------------------------------

use Phalcon\Loader;

ini_set("display_errors", 1);
error_reporting(E_ALL);

/** @var \Phalcon\Config $config */
$config = null;

/** @var PhalconRestJWT\Micro $app */
$app = null;

    //Constant Values will be used for the entire project
    define('APP_ENV', getenv('APP_ENV') ?: 'ef');
    define('NAMESPACE_PREFIX', 'PhalconRestJWT');

    define("ROOT_DIR", __DIR__ . '/..');
    define("APP_DIR", ROOT_DIR . '/app');
    define("VENDOR_DIR", ROOT_DIR . '/vendor');
    define("CONFIG_DIR", APP_DIR . '/config');
    define("ROUTES_DIR", APP_DIR . '/routes');
    define("TEST_DIR", ROOT_DIR . '/test');

    // Autoload Vendor dependencies from composer
    $vendorPath = VENDOR_DIR . '/autoload.php';
    $apploads = include $vendorPath;

    // Include dependencies set in config
    $apploadspath = CONFIG_DIR . "/autoload.php";
    $apploads = include $apploadspath;

    $library = APP_DIR . '/library';
    $appNamespace = array(
        NAMESPACE_PREFIX  => $library,
        NAMESPACE_PREFIX . '\App' => $library . '/app/',
        NAMESPACE_PREFIX . '\Bootstrap' => $library . '/bootstrap/',
        NAMESPACE_PREFIX . '\Events' => $library . '/events/',
        NAMESPACE_PREFIX . '\Constants' => $library . '/constants/',
        NAMESPACE_PREFIX . '\Exceptions' => $library . '/exceptions/',
        NAMESPACE_PREFIX . '\Http' => $library . '/http/',
        NAMESPACE_PREFIX . '\Interfaces' => $library . '/interfaces/',
        NAMESPACE_PREFIX . '\Security' => $library . '/security/'
    );

    $loader = new Loader();
    $namespaces = array_merge($apploads['Namespaces'], $appNamespace);
    $loader->registerNamespaces($namespaces);
    // Register Namespaces from autload dependencies, libraries and other directories
	$loader->registerDirs(
	    [
	        TEST_DIR,
	    ]
	);
    $loader->register();

