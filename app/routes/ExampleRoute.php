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
                [
                    '/sampleData',
                    'get',
                    'sampleData',
                    false
                ],
                [
                    '/sampleData',
                    'post',
                    'samplePost',
                    false
                ],
                [
                    '/testauthentication',
                    'map',
                    'testAuth',
                    true,
                    's1'
                ],
                [
                    '/testget/{message}',
                    'get',
                    'testGet',
                    false
                ],
                // login user = efren, pass= 12345678
                [
                    '/testacl',
                    'get',
                    'testacl',
                    true,
                    ['s4', 's2']
                ]
            ]);
    }
}
