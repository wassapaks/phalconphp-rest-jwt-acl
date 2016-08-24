<?php

/**
 * Event that check JWT Authentication
 *
 * @package Events
 * @subpackage Api
 * @author Jete O'Keeffe
 * @version 1.0
 */

namespace PhalconRestJWT\Security;

use \Phalcon\Acl\Adapter\Memory as AclList;
class AclRoles {

    /**
     * Setup an Event
     *
     * Phalcon event to make sure client sends a valid message
     * @return FALSE|void
     */
    public static function setAcl($resources,$roles) {

        //Create the ACL
        $acl = new \Phalcon\Acl\Adapter\Memory();
        //The default action is DENY access
        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        /*
         * ROLES
         * Admin - can do anything
         * User - can do most things
         * Restricted User - read only
         * */

        foreach ($roles as $role) {
            $acl->addRole(new \Phalcon\Acl\Role($role));
        }

        /*
         * RESOURCES
         * for each user, specify the 'controller' and 'method' they have access to (user=>[controller=>[method,method]],...)
         * this is created in an array as we later loop over this structure to assign users to resources
         * */

        foreach($resources as $arrResource){
            foreach($arrResource as $controller=>$arrMethods){
                $acl->addResource(new \Phalcon\Acl\Resource($controller),$arrMethods);
            }
        }

        /*
         * ACCESS
         * */
        foreach ($acl->getRoles() as $objRole) {
            $roleName = $objRole->getName();
                foreach ($resources[$roleName] as $resource => $method) {
                    $acl->allow($roleName,$resource,$method);
                }
        }

        try{
            file_put_contents(__DIR__."/acl.data", serialize($acl));
            return true;
        }
        catch (\Exception $e){
            throw new \Micro\Exceptions\HTTPExceptions(
                $e->getMessage(),
                500,
                array(
                    'dev' => 'Internal Error.',
                    'internalCode' => 'ACL0001',
                    'more' => ''
                )
            );
        }


    }

    public static function getAcl($user,$activeHandler, $handler){
        // Restore acl object from serialized file
        $acl = unserialize(file_get_contents(__DIR__."/acl.data"));

        $allowed = $acl->isAllowed($user, $activeHandler, $handler);

        return $allowed;
    }

}