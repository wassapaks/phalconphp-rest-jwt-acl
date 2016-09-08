<?php

namespace PhalconRestJWT\Events;


use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;
use PhalconRestJWT\Interfaces\IEvents;
use PhalconRestJWT\Constants\Services;
use PhalconRestJWT\Exceptions\Http;
use PhalconRestJWT\Security\AclRoles;
/**
 * Class Acl
 * @package PhalconRestJWT
 */

class Acl implements IEvents {

    /**
     * Dependency Injector
     * @var PhalconRestJWT\App\Di
     */
    protected $_di;

    public function __construct($di) {
        $this->_di = $di;
    }

    /**
     * Setup an Event
     *
     * Phalcon event to be attached to the micro
     * @return void
     */
    public function beforeExecuteRoute($event, $app) {


        if($this->_di->get(Services::USER_SERVICE)->loggedIn()){
            //Dirty solution cause lazy load cannot provide getActiveHandler on beforeExecuteRoute
            $ah = serialize($app->getActiveHandler()[0]);
            preg_match('/Controllers\\\(.*)";}/', $ah, $out);

            if(AclRoles::getAcl( $this->_di->get(Services::USER_SERVICE)->getUser()->id, $out[1], $app->getActiveHandler()[1])){
                return true;
            };

            // throw exception if reaches this part
            throw new Http(2020, 'ACL Record says your not allowed to access this route.',
                    array(
                        'dev' => 'Accessing this route is not permitted.',
                        'internalCode' => 'NF5001',
                        'more' => 'ACL error.'
                    )
            );
        }
    }
}
