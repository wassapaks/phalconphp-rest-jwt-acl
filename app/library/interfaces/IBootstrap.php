<?php

namespace PhalconRestJWT\Interfaces;

use PhalconRestJWT\Constants\Services,
	PhalconRestJWT\Interfaces\IBootstrap,
	Phalcon\DiInterface,
	PhalconRestJWT\App\Micro;
interface IBootstrap {
    public function boot(Micro $api, DiInterface $di, $config);

}
