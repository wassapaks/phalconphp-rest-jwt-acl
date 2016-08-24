<?php

namespace PhalconRestJWT\Events;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;
use PhalconRestJWT\Interfaces\IEvents;
use PhalconRestJWT\Constants\Services;
class JWT extends \Phalcon\Events\Manager implements IEvents{

    /**
     * Hmac Message
     * @var object
     */
    protected $_token;

    /**
     * Private key for HMAC
     * @var string
     */
    protected $_privateKey;

    public function __construct($config) {
        $this->_privateKey = $config->hashkey;
    }

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
        // End of checking unAuthenticated

        // Start of JWT Authentication
        // Authenticating the Token If expired or something is wrong in decoding


        // if($request->getHeader('Authorization')){

        // }

        // $parsetoken = explode(" ",$request->getHeader('Authorization'));



        $token = \Firebase\JWT\JWT::decode($request->getHeader('Authorization'), $this->_privateKey, array('HS256'));

        if($token){
            die("returned token");
            //$app->getDi()->get('User')->setUser($token);
            return $token;
        }

        die("should be error");
        // // End of JWT Authentication
        // throw new \Micro\Exceptions\HTTPExceptions(
        //     'Unauthorized Access',
        //     401,
        //     array(
        //         'dev' => 'Accessing this route is not permitted.',
        //         'internalCode' => 'NF5000',
        //         'more' => 'Pass a correct token.'
        //     )
        // );

    }
}
