<?php

namespace PhalconRestJWT\App;

/**
 * Class Bootstrap
 * @package PhalconRestJWT
 */

class Bootstrap
{
    protected $_executables;

    public function __construct(...$executables)
    {
        $this->_executables = $executables;
    }
    /**
     * Call boot function for each of the classes
     *
     * @return void
     */
    public function boot(...$args)
    {
        foreach ($this->_executables as $executable) {
            call_user_func_array([$executable, 'boot'], $args);
        }
    }
}