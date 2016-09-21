<?php

namespace App\Routes;
use PhalconRestJWT\App\Resources;

class ExampleRoute extends Resources {
    public function initialize()
    {
        $this
            ->handler('App\Controllers\ExampleController')
            ->lazy(true)
            ->collections([
                "/testpost" => [
                    'post',
                    'newnewsample',
                    false,
                    's1',
                ],
                "/testget/{id}" => [
                    'get',
                    'testAction',
                    false,
                    's2'
                ],
                "/authtest" => [
                    'post',
                    'testAuth',
                    false,
                    's3'
                ],
                "/ping" => [
                    'map',
                    'pingAction',
                    true,
                    's4'
                ]
            ]);
    }
}
