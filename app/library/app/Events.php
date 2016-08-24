<?php

namespace PhalconRestJWT\App;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;
use PhalconRestJWT\Constants\Services;

class Events
{
    protected $_executables;

    public function __construct(...$executables)
    {
        $this->_executables = $executables;

    }
    public function run(Micro $app){
        $eventsManager = new \Phalcon\Events\Manager();
        $eventsManager->enablePriorities(true);
        $prio = count($this->_executables);
        foreach($this->_executables as $listener){
 
            $eventsManager->attach('micro', $listener, $prio); // Set Priority
            $prio--;
        }

        $app->setEventsManager($eventsManager);
    }
}