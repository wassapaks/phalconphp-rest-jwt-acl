<?php



namespace PhalconRestJWT\App;

use PhalconRestJWT\Http\Request;
use PhalconRestJWT\Http\Response;
use PhalconRestJWT\Constants\Services;
use PhalconRestJWT\App\Router;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;

class Di extends \Phalcon\Di\FactoryDefault {

	public function __construct($config) {

		parent::__construct();

		$this->setShared(Services::REQUEST, new Request);

		$this->setShared(Services::RESPONSE, new Response);

		$this->setShared(Services::CONFIG, $config);

        $this->setShared(Services::EVENTS_MANAGER, new EventsManager);


	}
}
