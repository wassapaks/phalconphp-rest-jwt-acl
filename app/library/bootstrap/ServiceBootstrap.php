<?php

namespace PhalconRestJWT\Bootstrap;

use PhalconRestJWT\Constants\Services,
	PhalconRestJWT\Interfaces\IBootstrap,
	Phalcon\DiInterface,
	PhalconRestJWT\App\Micro,
	App\Services\User;

class ServiceBootstrap implements IBootstrap
{
    public function boot(Micro $app, DiInterface $di, $config)
    {

        $di->setShared(Services::USER_SERVICE, new User($di));

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

