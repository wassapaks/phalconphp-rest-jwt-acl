<?php

namespace Test;

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase
{
    public function testDependencyInjections(){
        $this->assertInstanceOf(\Phalcon\Config::class, $this->di->getShared('config'));
        $this->assertInstanceOf(\PhalconRestJWT\Http\Response::class, $this->di->getShared('response'));
        $this->assertInstanceOf(\PhalconRestJWT\Http\Request::class, $this->di->getShared('request'));
        $this->assertInstanceOf(\Phalcon\Events\Manager::class, $this->di->getShared('eventsManager'));
        $this->assertInstanceOf(\App\Services\User::class, $this->di->getShared('userService'));
    }
}