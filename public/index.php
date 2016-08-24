<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

/** @var \Phalcon\Config $config */
$config = null;

/** @var \PhalconRest\Api $app */
$app = null;

/** @var \PhalconRest\Http\Response $response */
$response = null;

function appError($message){
    die("PhalconRestJWT Application Error: " . $message);
}

try {

	define('APP_ENV', getenv('APP_ENV') ?: 'ef');
	define('NAMESPACE_PREFIX', 'PhalconRestJWT');

    define("ROOT_DIR", __DIR__ . '/..');
    define("APP_DIR", ROOT_DIR . '/app');
    define("VENDOR_DIR", ROOT_DIR . '/vendor');
    define("CONFIG_DIR", APP_DIR . '/config');
    define("ROUTES_DIR", APP_DIR . '/routes');
    
    $vendorPath = VENDOR_DIR . '/autoload.php';

    // Autoload Vendor dependencies
    if (!is_readable($vendorPath)) {
		appError('PhalconRestJWT Application Error: Unable to read autoloads from ' . $vendorPath);
    }

    $apploads = include $vendorPath;

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

    // Registering Autoloads
	$loader = new Phalcon\Loader();

	if(!isset($apploads['Namespaces'])){
       	appError('There were no namespaces declared in ' . $apploadspath);
	}

    $namespaces = array_merge($apploads['Namespaces'], $appNamespace);

	$loader->registerNamespaces($namespaces);

	if(isset($apploads['Dirs'])){
		$loader->registerDirs($apploads['Dirs']);
	}

	$loader->register();

	// Config
	$configPath = CONFIG_DIR . '/config.' . APP_ENV . '.php';

	if (!is_readable($configPath)) {
        appError('Unable to read config from ' . $configPath);
    }

    $config = new Phalcon\Config(include_once $configPath);

    //Generate DI
    $di = new PhalconRestJWT\App\Di($config);
    //Initialize Micro
    $app = new PhalconRestJWT\App\Micro($di);

    //Register Events
    $events = new PhalconRestJWT\App\Events(
            new PhalconRestJWT\Events\JWT($config)
        );
    $events->run($app);

    // // Bootstrap components
    $bootstrap = new PhalconRestJWT\Bootstrap(
        new PhalconRestJWT\Bootstrap\ServiceBootstrap()
    );
    //Boot all inside the bootstrap folder
    $bootstrap->boot($app, $di, $config);

    //Run the application
    $app->run();

} catch (\Exception $e) {
    
        // Handle exceptions
        $di = $app && $app->di ? $app->di : new PhalconRestJWT\Di\FactoryDefault();
        $response = $di->getShared(PhalconRestJWT\Constants\Services::RESPONSE);
        if(!$response || !$response instanceof PhalconRestJWT\Http\Response)
        {
            $response = new PhalconRestJWT\Http\Response();
        }

        if ($e instanceof PhalconRestJWT\Exceptions\Http){
            $response->sendContent($e->getError(), TRUE);
        }elseif($e instanceof UnexpectedValueException){
            $error = array(
                    "ApiStatus" => 401,
                    $e->getMessage()
                );
            $response->sendContent($error, TRUE);
        }

}
finally {

}

// // Setup configuration files
// $dir = dirname(__DIR__);
// $appDir = $dir . '/app';

// // Necessary requires to get things going
// require $appDir . '/library/utilities/debug/PhpError.php';
// require $appDir . '/library/interfaces/IRun.php';
// require $appDir . '/routes/RouteLoader.php';
// require $appDir . '/library/application/Micro.php';

// //Need Amazon S3 to Load
// require $appDir . '/library/utilities/Amazon/aws-autoloader.php';

// // Capture runtime errors
// //register_shutdown_function(['Utilities\Debug\PhpError','runtimeShutdown']);

// // Necessary paths to autoload & config settings
// $configPath = $appDir . '/config/';
// $config = $configPath . 'config.php';
// $autoLoad = $configPath . 'autoload.php';
// $amazonautoLoad = $appDir . '/library/utilities/Amazon/aws-autoloader.php';
// $routes = $configPath . 'routes.php';

// use \Models\Api as Api;

// try {
// 	$app = new Application\Micro();

// 	/**
// 	 * If the application throws an HTTPException, send it on to the client as json.
// 	 * Elsewise, just log it.
// 	 * TODO:  Improve this.
// 	 */
// 	function exceptionHandler($exception){
// 		error_log($exception);
// 		error_log($exception->getTraceAsString());
// 	}
// 	set_exception_handler('exceptionHandler');

	
// 	// Record any php warnings/errors
// 	//set_error_handler(['Utilities\Debug\PhpError','errorHandler']);

// 	// Setup App (dependency injector, configuration variables and autoloading resources/classes)
// 	$app->appDir = $appDir;
// 	$app->setAutoload($autoLoad, $appDir);
// 	$app->setConfig($config);

// 	//Attach Events to Micro
// 	$events = [
// 		new \Events\Api\TokenAuthentication($app->request->getHeader('Authorization'),$app->config->hashkey),
// 		new \Events\Acl()
// 	];
// 	$app->setEvents($events);

// 	// Setup RESTful Routes
// 	$app->setRoutes($routes);

// 	// Boom, Run
// 	$app->run();


// } catch(\UnexpectedValueException $e) {
// 	// This is error is for catching JWT Firebase ErrorException
// 	throw new \Micro\Exceptions\HTTPExceptions(
// 		$e->getMessage(),
// 		401,
// 		array(
// 			'dev' => '',
// 			'internalCode' => 'TK0000',
// 			'more' => ''
// 		)
// 	);
// } catch(Exception $e) {

// 	throw new \Micro\Exceptions\HTTPExceptions(
// 		$e->getMessage(),
// 		500,
// 		array(
// 			'dev' => 'Something went wrong on Processing Request',
// 			'internalCode' => 'NF0000',
// 			'more' => ''
// 		)
// 	);
// }


