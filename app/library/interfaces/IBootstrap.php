<?php

namespace PhalconRestJWT\Interfaces;

use PhalconRestJWT\Constants\Services;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;

interface IBootstrap {
    public function boot(Micro $api, DiInterface $di, $config);

}
