<?php

namespace PhalconRestJWT;

class Bootstrap
{
    protected $_executables;

    public function __construct(...$executables)
    {
        $this->_executables = $executables;
    }

    public function boot(...$args)
    {
        foreach ($this->_executables as $executable) {
            call_user_func_array([$executable, 'boot'], $args);
        }
    }
}