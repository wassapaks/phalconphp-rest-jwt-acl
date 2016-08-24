<?php

/**
 * Event that check JWT Authentication
 *
 * @package Events
 * @subpackage Api
 * @author Jete O'Keeffe
 * @version 1.0
 */

namespace PhalconRestJWT\Events;

use Security\AclRoles;
class Acl extends \Phalcon\Events\Manager implements IEvent {

    public function __construct() {
        // Add Event to validate message
        //$this->handleEvent();
    }

    /**
     * Setup an Event
     *
     * Phalcon event to make sure client sends a valid message
     * @return FALSE|void
     */
    public function beforeExecuteRoute($event, $app) {

        if($app->di->getShared('User')->loggedIn()){
            //Dirty solution cause lazy load cannot provide getActiveHandler on beforeExecuteRoute
            $ah = serialize($app->getActiveHandler()[0]);
            preg_match('/"Controllers\\\([^"]+)"/', $ah, $out);

            if(AclRoles::getAcl( $app->di->getShared('User')->getUser()->id, $out[1], $app->getActiveHandler()[1])){
                return true;
            };

            throw new \Micro\Exceptions\HTTPExceptions(
                'ACL Record says your not allowed to access this route.',
                401,
                array(
                    'dev' => 'Accessing this route is not permitted.',
                    'internalCode' => 'NF5001',
                    'more' => 'ACL error.'
                )
            );

        }

    }
}
