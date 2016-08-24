<?php

namespace PhalconRestJWT\Interfaces;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;

interface IEvents {
    public function beforeExecuteRoute($event,$api);

}
