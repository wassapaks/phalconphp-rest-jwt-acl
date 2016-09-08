<?php
/**
 *
 *  Route template configuration
 *
 * return [
 *    "prefix" => "/v1/example",
 *   "handler" => 'Controllers\ExampleController',
 *   "lazy" => true,
 *   "collection" => [
 *       "/ping" => [
 *           'method' => 'get',
 *           'function' => 'pingAction',
 *           'authentication' => FALSE,
 *           'resource' => 'rl1' // OPTIONAL if Authentication is True this should come from the database
 *       ]
 *   ]
 * ];
 *
 */
return [
    "prefix" => "/v1/example",
    "handler" => 'App\Controllers\ExampleController',
    "lazy" => true,
    "collection" => [
        "/samplenewnew" => [
            'method' => 'get',
            'function' => 'newnewsample',
            'authentication' => true,
            'acl' => 'rl100'
        ],
        "/ping" => [
            'method' => 'get',
            'function' => 'pingAction',
            'authentication' => false,
            'acl' => 'rl1'
        ],
        "/test/{id}" => [
            'method' => 'post',
            'function' => 'testAction',
            'authentication' => false,
            'acl' => 'rl1'
        ],
        "/auth/test/{name}" => [
            'method' => 'post',
            'function' => 'testAuth',
            'authentication' => false,
            'acl' => 'rl1'
        ],
    ]
];
