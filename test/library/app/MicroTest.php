<?php

namespace Test;

use PhalconRestJWT\App;
use App\Routes\UserRoute;
/**
 * Class MicroTest
 */
class MicroTest extends \UnitTestCase
{

	protected $app;

    public function testResourceSetShouldReturnMountedCollection(){
    	$app = new \PhalconRestJWT\App\Micro($this->di);
        $return = $app->resources(UserRoute::init('/user'));
        $this->assertInstanceOf(\PhalconRestJWT\App\Micro::class, $return);

        return $app;
    }

    /**
     * @depends testResourceSetShouldReturnMountedCollection
     */
    public function testGetUnauthenticated($app){
		var_dump($app->getUnauthenticated());   
    }

    // public function testGetUnauthenticatedCheckRoutes(){
        
    // }

    // public function testGetCollections(){
        
    // }

    // public function testGetCollectionsIfArray(){
        
    // }

    // public function testApplicationRunAllowedMethods(){

    // }

    // public function testApplicationRunAllowedHeaders(){
    	
    // }

    // public function testApplicationRunAllowedOrigins(){
    	
    // }

    // public function testApplicationRunIfReturnEmptySet(){
    	
    // }

    // public function testApplicationRunIfRouteNotFound(){
    	
    // }

}