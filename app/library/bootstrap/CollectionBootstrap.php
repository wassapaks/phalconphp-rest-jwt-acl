<?php

namespace PhalconRestJWT\Bootstrap;

use App\Routes\ExampleRoute;
use App\Routes\UserRoute;
use	PhalconRestJWT\Interfaces\IBootstrap;
use	Phalcon\DiInterface;
use	PhalconRestJWT\App\Micro;

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
        //we do this so we can document it, and we do not to create addition loop code

        $app->resources(ExampleRoute::init('/example'));
        $app->resources(UserRoute::init('/user'));
    }
}