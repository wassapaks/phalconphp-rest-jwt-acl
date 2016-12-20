<?php

namespace PhalconRestJWT\App;

use PhalconRestJWT\Http\Response;
use PhalconRestJWT\Exceptions\Http;

/**
 * Class Micro
 * @package PhalconRestJWT
 */

class Micro extends \Phalcon\Mvc\Micro {

	/**
	 * Pages that doesn't require authentication
	 * @var array
	 */
	protected $_noAuthPages;

	/**
	 * Micro Collection Routes
	 * @var array
	 */
	protected $_collections;

	public function __construct() {
		$this->_noAuthPages = array();
	}

	/**
	 * Mounting Resources
	 *
	 * @return void It only mounts the collections from routes
	 */
	public function resources($collection){

		$this->_collections[] = [
			"prefix" => $collection->getPrefix(),
			"handler" => $collection->getHandler(),
			"collection" => $collection->getCollections()
		];

		$this->_noAuthPages = array_merge_recursive($this->_noAuthPages, $collection->getNoAuth());
		return $this->mount($collection);
	}

	/*
	 * An old solution from my past
	 * my first router solution before using namespaces,
	 * i just placed it here for remembrance
	 *
    private function routeLoader() {
        $collectionFiles = scandir(ROUTES_DIR);
        $col = new \Phalcon\Mvc\Micro\Collection();

        foreach ($collectionFiles as $collectionFile) {
            $pathinfo = pathinfo($collectionFile);

            //Only include php files
            if ($pathinfo['extension'] === 'php') {
                // The collection files return their collection objects, so mount
                // them directly into the router.
            	$route = include(ROUTES_DIR.'/'.$collectionFile);

				// Made my own benchmark and it still works great on 500 api request per second
				// In progress middleware caching
            	//if (preg_match("/^".str_replace('/', '\/', $route['prefix'])."\//i", $_SERVER['REQUEST_URI'])) {
            		$this->_collections[] = $route;

		        	$col
		            // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		            ->setPrefix($route['prefix'])
		            // Must be a string in order to support lazy loading
		            ->setHandler($route['handler'])
		            ->setLazy($route['lazy']);

				    foreach ($route['collection'] as $v => $r) {
				    			if(!isset($r['authentication']))
				    				$r['authentication']=false;

						            if ($r['authentication']===false) {
						                $method = strtolower($r['method']);

						                if (! isset($this->_noAuthPages[$method])) {
						                    $this->_noAuthPages[$method] = array();
						                }

						                $this->_noAuthPages[$method][] = $route['prefix'].$v;
						            }
						            $col->{$r['method']}(
							            	$v,
							            	$r['function']
						            	);
				    }
				    //break;
		        //}
		    }

        }

		$this->mount($col);

    }
	* */
	/**
	 * Get collections
	 *
	 * @return \Phalcon\Mvc\Micro\Collection
	 */
    public function getCollections(){
        return $this->_collections;
    }

	/**
	 * Get No Auth Pages
	 *
	 * @return Array
	 */
    public function getUnauthenticated(){
        return $this->_noAuthPages;
    }

	/**
	 * Main run block that executes the micro application
	 *
	 */
	public function run() {

		// Call route loader
		//$this->routeLoader();

		// Send headers
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
