<?php

namespace PhalconRestJWT\Bootstrap;


use PhalconRestJWT\Constants\Services;
use	PhalconRestJWT\Interfaces\IBootstrap;
use	Phalcon\DiInterface;
use	PhalconRestJWT\App\Micro;

/**
 * Class ServiceBootstrap
 * @package PhalconRestJWT
 */
class ServiceBootstrap implements IBootstrap
{

    /**
      * Set Shared dependencies from bootstrap folder, when you add additional helpers or 
      * services just create a folder and add a bootstrap loader for your files in the bootstrap file
      *
      * @param PhalconRestJWT\App\Micro $app Array structure from your config file.
      * @param Phalcon\DiInterface $di Array structure from your config file.
      * @param PhalconRestJWT\App\Config $config Array structure from your config file.
      *
      * @return void
      */
    public function boot(Micro $app, DiInterface $di, $config)
    {

        $di->setShared(Services::DB, function() use ($di) {
            $type = strtolower($di["config"]["database"]["adapter"]);
            $creds = array(
                'host' => $di["config"]["database"]["host"],
                'username' => $di["config"]["database"]["username"],
                'password' => $di["config"]["database"]["password"],
                'dbname' => $di["config"]["database"]["name"]
            );
            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($creds);
            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($di->get(Services::EVENTS_MANAGER));
            return $connection;
        });

		// $di->setShared(Services::ERROR_HELPER, new \Services\ErrorMessages());

		// $di->setShared(Services::MAILER, new \Services\Mailer());

		// $di->setShared(Services::TOKEN_PARSER, new \Services\Mailer());

		// $di->setShared(Services::ACL, new Acl);
		
    }
}

