<?php
/**
 * @author GEEKSNEST
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

return [
    "prefix" => "/v1/example",
    "handler" => 'Controllers\ExampleController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'get',
            'route' => '/ping',
            'function' => 'pingAction',
            'authentication' => FALSE,
            'resource' => 'rl1' // OPTIONAL if Authentication is True
        ]
    ]
];

 */
return [
    "prefix" => "/v1/example",
    "handler" => 'App\Controllers\ExampleController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'get',
            'route' => '/samplenewnew',
            'function' => 'newnewsample',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/ping',
            'function' => 'pingAction',
            'authentication' => FALSE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/test/{id}',
            'function' => 'testAction',
            'authentication' => FALSE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/auth/test/{name}',
            'function' => 'testAuth',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
    ]
];
