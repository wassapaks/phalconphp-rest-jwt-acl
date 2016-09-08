<?php

namespace App\Services;


use Phalcon\DiInterface;
use PhalconRestJWT\Exceptions\Http;
use PhalconRestJWT\Constants\Services;

/**
 * Class User Service
 * @package PhalconRestJWT
 */
class User{

    /**
     * User array information
     *
     * @var array
     */
    protected $user = [];

    /**
     * User table map
     *
     * @var string
     */
    protected $table = null;

    /**
     * Config
     *
     * @var Phalcon\Config
     */
    protected $_config;

    /**
     * Initialize DI in Class
     *
     * @param Phalcon\DiInterface $di
     *
     * @return void
     */
    public function __construct($config){
        $this->_config = $config;
    }

    /**
     *
     * @return array user information
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param array user set information
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     *
     * Check if a user is currently logged in
     */
    public function loggedIn()
    {
        return !!$this->user;
    }

    /**
     * @return bool
     *
     * Check if a user is currently logged in
     */
    public function getMyRole()
    {
        /** @var User $userModel */
        $model = $this->table;
        $rec = $model::findFirst(
            array(
                "memberid = 'OWNER'",
                "columns" => "memberid"
            ));
        return $rec;
    }

    /**
     * @return array Authorized user and set token
     *
     */

    public function authorizeUser($cred, $table, $refresh = false)
    {
        $model = '\\App\\Models\\'.$table;
        $this->table = $model;

        $query  = '';

        if($refresh){
            reset($cred);

            $query  = ' '.key($cred).'="'.$cred[key($cred)].'"';
        }else{
            $query  = ' (username="'.$cred['username'].'" OR email="'.$cred['username'].'" AND  password="'. sha1($cred['password']).'")';
        }

        $user = $model::findFirst($query);

        if($user){
            $data = $this->genToken($user->getPayLoad());
            $data["refresh"] = $refresh;
        }else{
            throw new Http(2020, 'Information invalid.',
                array(
                    'dev' => "User Service Error, wrong user name or password.",
                    'internalCode' => "UserS-1",
                    'more' => null
                )
            );
        }

        return $data;
    }

    /**
     * @return string set of token
     *
     */
    public function genToken($payload){

        $timestamp = time();
        $payload['iat'] = $timestamp;
        $payload['exp'] = strtotime('+' . $this->_config['tokenEXP']['token'], $timestamp);


        $accesstoken = \Firebase\JWT\JWT::encode($payload, $this->_config['hashkey']);
        $rtoken = \Firebase\JWT\JWT::encode(array(
            "id" => $payload["id"],
            "exp" => strtotime('+' . $this->_config['tokenEXP']['refreshToken'], $timestamp),
            "iat" => $timestamp
        ),$this->_config['hashkey']);

        return array(
            'token' => $accesstoken,
            'refreshtoken' => $rtoken
        );
    }
}
