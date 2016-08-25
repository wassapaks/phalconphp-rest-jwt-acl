<?php

error_reporting(1);
ini_set('display_errors',1); 

/** @var \Phalcon\Config $config */
$config = null;

/** @var PhalconRestJWT\Micro $app */
$app = null;

 /**
  * Function to terminate if autoload path failed to execute
  *
  * @param string $message your error message passed
  *
  * @return void
  */
function appError($message){
    die("PhalconRestJWT Application Error: " . $message);
}

try {

    //Constant Values will be used for the entire project
    define('APP_ENV', getenv('APP_ENV') ?: 'ef');
    define('NAMESPACE_PREFIX', 'PhalconRestJWT');

    define("ROOT_DIR", __DIR__ . '/..');
    define("APP_DIR", ROOT_DIR . '/app');
    define("VENDOR_DIR", ROOT_DIR . '/vendor');
    define("CONFIG_DIR", APP_DIR . '/config');
    define("ROUTES_DIR", APP_DIR . '/routes');
    
    // Autoload Vendor dependencies from composer
    $vendorPath = VENDOR_DIR . '/autoload.php';
    
    if (!is_readable($vendorPath)) {
        appError('PhalconRestJWT Application Error: Unable to read autoloads from ' 
            . $vendorPath);
    }

    $apploads = include $vendorPath;

    // Include dependencies set in config
    $apploadspath = CONFIG_DIR . "/autoload.php";

    if (!is_readable($apploadspath)) {
        appError('Unable to read autoloads from ' . $apploadspath);
    }

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

    $loader = new Phalcon\Loader();

    if (!isset($apploads['Namespaces'])) {
        appError('There were no namespaces declared in ' . $apploadspath);
    }

    $namespaces = array_merge($apploads['Namespaces'], $appNamespace);

    $loader->registerNamespaces($namespaces);

    if (isset($apploads['Dirs'])) {
        $loader->registerDirs($apploads['Dirs']);
    }

    // Register Namespaces from autload dependencies, libraries and other directories
    $loader->register();

    
    $configPath = CONFIG_DIR . '/config.' . APP_ENV . '.php';

    if (!is_readable($configPath)) {
        appError('Unable to read config from ' . $configPath);
    }

    // Create Config
    $config = new Phalcon\Config(include_once $configPath);

    // Generate DI 
    $di = new PhalconRestJWT\App\Di($config);
    
    // Initialize Micro
    $app = new PhalconRestJWT\App\Micro($di);

    $events = new PhalconRestJWT\App\Events(
            new PhalconRestJWT\Events\JWT($config)
        );

    // Register Events
    $events->run($app);

    // Bootstrap components
    $bootstrap = new PhalconRestJWT\App\Bootstrap(
        new PhalconRestJWT\Bootstrap\ServiceBootstrap()
    );

    // Initialize your bootstrap components
    $bootstrap->boot($app, $di, $config);

    // Run the application
    $app->run();

} catch (\Exception $e) {
    // Handle exceptions
    $di = $app && $app->di ? $app->di : new PhalconRestJWT\Di\FactoryDefault();

    $response = $di->getShared(PhalconRestJWT\Constants\Services::RESPONSE);

    if (!$response || !$response instanceof PhalconRestJWT\Http\Response) {
        $response = new PhalconRestJWT\Http\Response();
    }

    // Catch Exception, from JWT or from HTTP class
    if ($e instanceof PhalconRestJWT\Exceptions\Http) {
        $error = $e->getError();
    } elseif ( 
        $e instanceof UnexpectedValueException || 
        $e instanceof ExpiredException || 
        $e instanceof InvalidArgumentException || 
        $e instanceof DomainException || 
        $e instanceof SignatureInvalidException || 
        $e instanceof BeforeValidException
    ) {
        $error = array(
            "ApiStatus" => 401,
            "errorMessage" => "Unauthorized",
            "errorDev" => array(
                'dev' => $e->getMessage(),
                'internalCode' => "Micro - 2",
                'more' => null
                )
            );
    }else{
        $error = $e->getMessage();
    }
    $response->sendContent($error, true);
} 