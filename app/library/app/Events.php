<?php

namespace PhalconRestJWT\App;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRestJWT\App\Micro;
use PhalconRestJWT\Constants\Services;

/**
 * Class Events
 * @package PhalconRestJWT
 */
class Events
{

    /**
     * Array Classes from Index event registration
     * @var array Class
     */
    protected $_executables;

    public function __construct(...$executables)
    {
        $this->_executables = $executables;

    }

    /**
     * Run function to Attach all Events to Micro
     * @var array Class
     */
    public function run(Micro $app){
        $eventsManager = new \Phalcon\Events\Manager();
        
        $eventsManager->enablePriorities(true);
        
        $prio = count($this->_executables);

        foreach ($this->_executables as $listener) {
            // Attach Event to Micro
            $eventsManager->attach('micro', $listener, $prio); // Set Priority
            $prio--;
        }

        $app->setEventsManager($eventsManager);
    }
}