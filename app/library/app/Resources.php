<?php
/**
 * Class Resources
 * @package PhalconRestJWT
 */

namespace PhalconRestJWT\App;


class Resources extends \Phalcon\Mvc\Micro\Collection
{
    /**
     * Pages that doesn't require authentication
     * @var array i need to recreate this to pass unto micro
     */
    protected $_noAuthPages = array();

    /**
     * Micro Collection Routes
     * @var array i need to recreate this to pass unto micro
     */
    protected $_collections = array();

    /**
     * Initialization when resourceRoute is called
     *
     * @return $this
     */
    public static function init($prefix)
    {

        $calledClass = get_called_class();

        $resource = new $calledClass($prefix);
        $resource->prefix($prefix);
        $resource->initialize();

        return $resource;
    }

    /**
     * Soon for documentation purpose
     *
     * @return $this
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    /**
     * Soon for documentation purpose
     *
     * @return $this
     */
    public function setDescription($description){
        $this->name = $description;
        return $this;
    }

    /**
     * collection prefix
     *
     * @return $this
     */
    public function prefix($prefix){
        $this->setPrefix($prefix);
        return $this;
    }

    /**
     * collection handler
     *
     * @return $this
     */
    public function handler($handler){
        $this->setHandler($handler);
        return $this;
    }

    /**
     * collection routes
     *
     * @return $this
     */
    public function collections($route){
        $this->_collections = $route;
        foreach ($route as $url => $r) {

            $method = strtolower($r[0]);

            if(!isset($r[2]))
                $r[2]=false;

            if ($r[2]===false) {

                if (!isset($this->_noAuthPages[$method])) {
                    $this->_noAuthPages[$method] = array();
                }

                $this->_noAuthPages[$method][] = $this->getPrefix().$url;
            }
            $this->{$method}(
                $url,
                $r[1]
            );
        }

        return $this;
    }

    /**
     * @return _noAuthPages
     */
    public function getNoAuth(){
        return $this->_noAuthPages;
    }

    /**
     * @return $this
     */
    public function lazy($bol){
        $this->setLazy($bol);
        return $this;
    }

    /**
     * @return _collections
     */
    public function getCollections(){
        return $this->_collections;
    }
}