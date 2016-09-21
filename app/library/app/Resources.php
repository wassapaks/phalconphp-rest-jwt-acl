<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 19/09/2016
 * Time: 2:45 PM
 */

namespace PhalconRestJWT\App;


class Resources extends \Phalcon\Mvc\Micro\Collection
{
    protected $_noAuthPages = array();
    protected $_collections = array();

    public static function init($prefix)
    {

        $calledClass = get_called_class();

        $resource = new $calledClass($prefix);
        $resource->prefix($prefix);
        $resource->initialize();

        return $resource;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function setDescription($description){
        $this->name = $description;
        return $this;
    }

    public function prefix($prefix){
        $this->setPrefix($prefix);
        return $this;
    }

    public function handler($handler){
        $this->setHandler($handler);
        return $this;
    }
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
    public function getNoAuth(){
        return $this->_noAuthPages;
    }
    public function lazy($bol){
        $this->setLazy($bol);
        return $this;
    }
    public function getCollections(){
        return $this->_collections;
    }
}