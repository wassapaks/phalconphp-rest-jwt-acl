<?php

/**
 * A Micro application to run simple/rest based applications
 *
 * @package Application
 * @author Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html
 * @example
 */

namespace PhalconRestJWT\App;

use PhalconRestJWT\Http\Response,
PhalconRestJWT\Exceptions\Http;

class Micro extends \Phalcon\Mvc\Micro {

	/**
	 * Pages that doesn't require authentication
	 * @var array
	 */
	protected $_noAuthPages;

	/**`
	 * User level access
	 * @var array
	 */

	protected $_levels;

	/**
	 * APP PATH VALUE
	 */

	public $appDir;

	/**
	 * Constructor of the App
	 */
	protected $_collections;

	public function __construct() {
		$this->_noAuthPages = array();
		$this->_levels = array();
	}

	/**
     * Route Loader
     */
    private function routeLoader(){
        $collections = array();
        $collectionFiles = scandir(ROUTES_DIR);
        foreach($collectionFiles as $collectionFile){
            $pathinfo = pathinfo($collectionFile);
            //Only include php files
            if($pathinfo['extension'] === 'php'){
                // The collection files return their collection objects, so mount
                // them directly into the router.

            	$route = include(ROUTES_DIR.'/'.$collectionFile);
            	if(preg_match("/^".str_replace('/', '\/', $route['prefix'])."\//i", $_SERVER['REQUEST_URI'])){

            		$collections[] = $this->microCollection($route);
            		break;
            	}
            }	
        }

		foreach($collections as $collection){
			$this->mount($collection);
		}

    }
    /**
     * Micro Collection
     */
    private function microCollection($route){
        $col = new \Phalcon\Mvc\Micro\Collection();
        $col
            // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
            ->setPrefix($route['prefix'])
            // Must be a string in order to support lazy loading
            ->setHandler($route['handler'])
            ->setLazy($route['lazy']);

        foreach($route['collection'] as $r){
        	$getRoute = preg_split("/^".str_replace('/', '\/', $route['prefix'])."\//i", $_SERVER['REQUEST_URI']);
        	if(!empty($getRoute)){
        		if( '/'.$getRoute[1] === $r['route']) {
		            //Store unauthenticated Collection
		            if($r['authentication']===false){
		                $method = strtolower($r['method']);
		                if (! isset($this->_noAuthPages[$method])) {
		                    $this->_noAuthPages[$method] = array();
		                }
		                $this->_noAuthPages[$method][] = $route['prefix'].$r['route'];
		            }
		            $col->{$r['method']}($r['route'], $r['function'], isset($r['resource']) ? $r['resource']:NULL);
		            break;
        		}
        	}

        }

        return $col;
    }
    public function getCollections(){
        return $this->collections;
    }
    public function getNoAuthPages(){
        return $this->_noAuthPages;
    }
	/**
	 * 
	 *
	 *
	 */
	public function getUnauthenticated() {
		return $this->_noAuthPages;
	}
	/**
	 *
	 */
	public function getLevels() {
		return $this->_levels;
	}
	/**
	 * Main run block that executes the micro application
	 *
	 */
	public function run() {

		$this->routeLoader();

		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->sendHeaders();

		// Access-Control headers are received during OPTIONS requests
		if ($this->request->isOptions()) {
			$this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT');
			$this->response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type, Authorization');
			$this->response->send();
		}


		$this->after(function(){

			// Results returned from the route's controller.  All Controllers should return an array
			$records = $this->getReturnedValue();

			if(empty($records)){
		        throw new Http(1010, 'Empty Set',
		            array(
		                'dev' => "Returned empty set",
		                'internalCode' => "Micro-1",
		                'more' => null
		            )
		        );
			}

			$response = new Response();
			$response->sendContent($records);
			
			return;

		});

		// Handle any routes not found
		$this->notFound(function () {
		        throw new Http(1030, 'Route not Found!',
		            array(
		                'dev' => "Url was not found.",
		                'internalCode' => "Micro-2",
		                'more' => null
		            )
		        );
		});

		$this->handle();

	}


}
