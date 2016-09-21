<?php

namespace App\Routes;
use PhalconRestJWT\App\Resources;

class UserRoute extends Resources {
    public function initialize()
    {
        $this
            ->handler('App\Controllers\UsersController')
            ->lazy(true)
            ->collections([
                "/login" => [
                    'post',
                    'userLogin',
                    false,
                    'userlogin'
                ],
                "/refreshtoken" => [
                    'post',
                    'refreshtoken',
                    false,
                    'userlogin'
                ],
                "/initroles" => [
                    'get',
                    'initializeRoles',
                    false,
                    'roles'
                ]
            ]);
    }
}