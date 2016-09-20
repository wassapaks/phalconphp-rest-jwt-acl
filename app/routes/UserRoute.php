<?php

namespace App\Routes;
use PhalconRestJWT\App\Resources;

class UserRoute extends Resources {
    public function initialize()
    {
        $this
            ->handler('App\Controllers\ExampleController')
            ->lazy(true)
            ->collections([
                "/userlogin" => [
                    'post',
                    'memberLogin',
                    false,
                    'rl1'
                ],
                "/refreshtoken" => [
                    'post',
                    'refreshtoken',
                    false,
                    'rl1'
                ],
                "/initroles" => [
                    'post',
                    'initializeRoles',
                    false,
                    'rl1'
                ]
            ]);
    }
}