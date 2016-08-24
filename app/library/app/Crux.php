<?php

/**
 * A Micro application to run simple/rest based applications
 *
 * @package Application
 * @author Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html
 * @example
 */

namespace PhalconRestJWT\App;

class Crux {

	/**
	 * Set Dependency Injector with configuration variables
	 *
	 * @throws Exception		on bad database adapter
	 * @param string $file		full path to configuration file
	 */
	public static function setConfig($file) {
		if (!file_exists($file)) {
			throw new \Micro\Exceptions\HTTPExceptions(
				'API Error',
				500,
				array(
					'dev' => 'Unable to load config file',
					'internalCode' => 'NF1003',
					'more' => 'Check config location.'
				)
			);
		}

		$di = new \Phalcon\DI\FactoryDefault();


		$di->setShared('collections', new \Route\RouteLoader($this->appDir));

		// By its class name
		$di->set("request", new Request());

		$configFile = require $file;

		$di->set('config', new \Phalcon\Config($configFile));

		$di->set('db', function() use ($di) {
			$type = strtolower($di->get('config')->database->adapter);
			$creds = array(
				'host' => $di->get('config')->database->host,
				'username' => $di->get('config')->database->username,
				'password' => $di->get('config')->database->password,
				'dbname' => $di->get('config')->database->name
			);

			if ($type == 'mysql') {
				$connection =  new \Phalcon\Db\Adapter\Pdo\Mysql($creds);
			} else if ($type == 'postgres') {
				$connection =  new \Phalcon\Db\Adapter\Pdo\Postgesql($creds);
			} else if ($type == 'sqlite') {
				$connection =  new \Phalcon\Db\Adapter\Pdo\Sqlite($creds);
			} else {
				throw new \Micro\Exceptions\HTTPExceptions(
					'API Error',
					500,
					array(
						'dev' => 'Bad database adapter.',
						'internalCode' => 'NF1002',
						'more' => 'Check system adapter availability'
					)
				);
			}

			return $connection;
		});

		/**
		 * If our request contains a body, it has to be valid JSON.  This parses the
		 * body into a standard Object and makes that vailable from the DI.  If this service
		 * is called from a function, and the request body is nto valid JSON or is empty,
		 * the program will throw an Exception.
		 */
		$di->setShared('requestBody', function() use ($di) {
			$in = file_get_contents('php://input');
			$in = json_decode($in, FALSE);

			// JSON body could not be parsed, throw exception
			if($in === null){
				throw new \Micro\Exceptions\HTTPExceptions(
					'There was a problem understanding the data sent to the server by the application.',
					409,
					array(
						'dev' => 'The JSON body sent to the server was unable to be parsed.',
						'internalCode' => 'REQ1000',
						'more' => ''
					)
				);
			}
			return $in;
		});

		$di->set('User', function () use ($di) {
			$user = new \Services\User($di);
			return $user;
		});

		$di->set('ErrorMessage', new \Services\ErrorMessages());
		$di->set('Mailer', new \Services\Mailer($configFile));

		$this->setDI($di);
	}

	/**
	 * Set namespaces to tranverse through in the autoloader
	 *
	 * @link http://docs.phalconphp.com/en/latest/reference/loader.html
	 * @throws Exception
	 * @param string $file		map of namespace to directories
	 */
	public static function registerLoader($lib, $app) {

		// Set dir to be used inside include file
		$namespaces = include $app;

		$loader = new \Phalcon\Loader();

		$loader->registerClasses(
				
		);
		// var_dump($namespaces);
		// die();
		$loader->registerDirs( $namespaces );
		$loader->registerNamespaces($namespaces)->register();
	}

	/**
	 * Set events to be triggered before/after certain stages in Micro App
	 *
	 * @param object $event		events to add
	 */
	public function setEvents($event) {
		$events = new \Phalcon\Events\Manager();
		$events->enablePriorities(true);
		$prio = count($event);
		foreach($event as $listener){
			$events->attach('micro', $listener, $prio); // Set Priority
			$prio--;
		}
		$this->setEventsManager($events);

	}

}
