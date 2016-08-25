<?php

namespace PhalconRestJWT\Events;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;
use PhalconRestJWT\Interfaces\IEvents;
use PhalconRestJWT\Constants\Services;
use PhalconRestJWT\Exceptions\Http;

/**
 * Class JWT
 * @package PhalconRestJWT
 */

class JWT extends \Phalcon\Events\Manager implements IEvents{

    /**
     * Token from Header
     * @var string
     */
    protected $_token;

    /**
     * Private key for crypting and decrypting token, set on the config file
     * @var string
     */
    protected $_privateKey;

    public function __construct($config) {
        $this->_privateKey = $config->hashkey;
    }

    /**
     * Attach to micro event
     * @return string token
     */
    public function beforeExecuteRoute($event,$app) {
        
        $request = $app->getDi()->get(Services::REQUEST);

        // Check if it does not need authentication return and skip JWT Checking
        $method = strtolower($app->router->getMatchedRoute()->getHttpMethods());

        $unAuthenticated = $app->getUnauthenticated();
        if (isset($unAuthenticated[$method])) {
             $unAuthenticated = array_flip($unAuthenticated[$method]);
             if (isset($unAuthenticated[$app->router->getMatchedRoute()->getPattern()])) {
                 return true;
             }
        }

        // Start of JWT Authentication
        // Authenticating the Token If expired or something is wrong in decoding
        if (!$request->getHeader('Authorization')) {
            throw new Http(2020, 'Unauthorized.',
                array(
                    'dev' => "No headers found.",
                    'internalCode' => "JWT-1",
                    'more' => null
                )
            );
        }

        $parsetoken = explode(" ",$request->getHeader('Authorization'));

        $token = \Firebase\JWT\JWT::decode($parsetoken[1], $this->_privateKey, array('HS256'));

        if ($token) {
            return $token;
        }

        // throw exception if reaches this part
        throw new Http(2020, 'Unauthorized.',
            array(
                'dev' => "End of Authentication, passed back error.",
                'internalCode' => "JWT-2",
                'more' => null
            )
        );

    }
}
