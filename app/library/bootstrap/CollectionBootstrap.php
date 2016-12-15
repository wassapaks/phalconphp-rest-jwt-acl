<?php

namespace PhalconRestJWT\Bootstrap;

use App\Routes\ExampleRoute;
use App\Routes\UserRoute;
use	PhalconRestJWT\Interfaces\IBootstrap;
use	Phalcon\DiInterface;
use	PhalconRestJWT\App\Micro;
use PhalconRestJWT\Constants\Services;

/**
 * Class Collection
 * @package PhalconRestJWT
 */

class CollectionBootstrap implements IBootstrap
{
    public function boot(Micro $app, DiInterface $di, $config)
    {
        //We have to specify the routes
        //because once api versioning comes, we will be deleting route file just to disable that route version
        //we do this so we can document it, and to avoid looping file just to get routes
        $app->resources(UserRoute::init('/user'));
        $app->resources(ExampleRoute::init('/example'));

        //Share the collection for the purpose of initializing roles
        $di->setShared(Services::COLLECTIONS, function() use ($app) {
            return $app->getCollections();
        });

    }
}