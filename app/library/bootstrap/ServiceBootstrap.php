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

        $di->setShared(Services::DB, function() use ($config) {
            
            $type = strtolower($config->database->adapter);
            $creds = array(
                'host' => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname' => $config->database->name
            );

            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($creds);

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($this->get(Services::EVENTS_MANAGER));

            return $connection;

        });

		// $di->setShared(Services::ERROR_HELPER, new \Services\ErrorMessages());

		// $di->setShared(Services::MAILER, new \Services\Mailer());

		// $di->setShared(Services::TOKEN_PARSER, new \Services\Mailer());

		// $di->setShared(Services::ACL, new Acl);
		
    }
}

