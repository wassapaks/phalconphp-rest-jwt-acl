<?php

namespace Test;

/**
 * Class DiTest
 */
class DiTest extends \UnitTestCase
{
    public function testDiDefaultConfigInstance(){
        $this->assertInstanceOf(\Phalcon\Config::class, $this->di->getShared('config'));
    }

    public function testDiDefaultResponseInstance(){
    	$this->assertInstanceOf(\PhalconRestJWT\Http\Response::class, $this->di->getShared('response'));
    }

    public function testDiDefaultRequestInstance(){
    	$this->assertInstanceOf(\PhalconRestJWT\Http\Request::class, $this->di->getShared('request'));
    }

    public function testDiDefaultEventsManagerInstance(){
    	$this->assertInstanceOf(\Phalcon\Events\Manager::class, $this->di->getShared('eventsManager'));
    }

    public function testDiDefaultUserServiceInstance(){
    	$this->assertInstanceOf(\App\Services\User::class, $this->di->getShared('userService'));    	
    }

    public function testDiNotExisting(){
    	$this->expectException(\Phalcon\Di\Exception::class);
    	$this->di->getShared('notExisting');
    }

}