<?php

namespace PhalconRestJWT\App;

use PhalconRestJWT\Http\Request;
use PhalconRestJWT\Http\Response;
use PhalconRestJWT\Constants\Services;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use App\Services\User;

/**
 * Class Di
 * @package PhalconRestJWT
 */

class Di extends \Phalcon\Di\FactoryDefault {

	/**
	  * Set Shared dependencies
	  *
	  * @param Phalcon\Config $config Array structure from your config file.
	  *
	  * @return void
	  */
	public function __construct($config) {

		parent::__construct();

		$this->setShared(Services::REQUEST, new Request);

		$this->setShared(Services::RESPONSE, new Response);

		$this->setShared(Services::CONFIG, $config);

        $this->setShared(Services::EVENTS_MANAGER, new EventsManager);

        $this->setShared(Services::USER_SERVICE, new User($config));

	}
}
