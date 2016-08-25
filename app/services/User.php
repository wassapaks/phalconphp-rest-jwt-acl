<?php

/**
 * Event that check JWT Authentication
 *
 * @package Events
 * @subpackage Api
 * @author Jete O'Keeffe
 * @version 1.0
 */

namespace App\Services;

use PhalconRestJWT\App\Micro,
    Phalcon\DiInterface,
    PhalconRestJWT\Exceptions\Http;

class User{

    protected $user = [];

    protected $table = null;

    protected $app;

    public function __construct($di){
        $this->di = $di;
    }

    public function getUser()
    {
        return $this->user;
    }

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

    protected function getDetailsForIdentity($identity)
    {

    }

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

    public function genToken($payload){

        $timestamp = time();
        $payload['iat'] = $timestamp;
        $payload['exp'] = strtotime('+' . $this->di['config']['tokenEXP']['token'], $timestamp);


        $accesstoken = \Firebase\JWT\JWT::encode($payload, $this->di['config']['hashkey']);
        $rtoken = \Firebase\JWT\JWT::encode(array(
            "id" => $payload["id"],
            "exp" => strtotime('+' . $this->di['config']['tokenEXP']['refreshToken'], $timestamp),
            "iat" => $timestamp
        ),$this->di['config']['hashkey']);

        return array(
            'token' => $accesstoken,
            'refreshtoken' => $rtoken
        );
    }

    /**
     * @param $name
     *
     * @return \PhalconRest\Auth\AccountType Account-type
     */
    public function getAccountType($name)
    {
        
    }

    /**
     * @param string $token Token to authenticate with
     *
     * @return bool
     * @throws Exception
     */
    public function authenticateToken($token)
    {

    }
}
