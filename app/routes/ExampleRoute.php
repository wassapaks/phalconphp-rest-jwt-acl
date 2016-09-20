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
                "/samplenewnew" => [
                    'get',
                    'newnewsample',
                    false,
                    ['blogadd', 'blogedit', 'blogdelete']
                ],
                "/test/{id}" => [
                    'post',
                    'testAction',
                    false,
                    ['cmsadmin', 'etc']
                ],
                "/auth/test/{name}" => [
                    'post',
                    'testAuth',
                    false,
                    'rl1'
                ],
                "/ping" => [
                    'get',
                    'pingAction',
                    false,
                    'rl1'
                ]
            ]);
    }
}

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
//return [
//    "prefix" => "/v1/example",
//    "handler" => 'App\Controllers\ExampleController',
//    "lazy" => true,
//    "collection" => [
//        "/samplenewnew" => [
//            'method' => 'get',
//            'function' => 'newnewsample',
//            'authentication' => true,
//            'acl' => 'rl100'
//        ],
//        "/ping" => [
//            'method' => 'get',
//            'function' => 'pingAction',
//            'authentication' => false,
//            'acl' => 'rl1'
//        ],
//        "/test/{id}" => [
//            'method' => 'post',
//            'function' => 'testAction',
//            'authentication' => false,
//            'acl' => 'rl1'
//        ],
//        "/auth/test/{name}" => [
//            'method' => 'post',
//            'function' => 'testAuth',
//            'authentication' => false,
//            'acl' => 'rl1'
//        ],
//    ]
//];


///**
// *
// *  Route template configuration
// *
// * return [
// *    "prefix" => "/v1/example",
// *   "handler" => 'Controllers\ExampleController',
// *   "lazy" => true,
// *   "collection" => [
// *       "/ping" => [
// *           'method' => 'get',
// *           'function' => 'pingAction',
// *           'authentication' => FALSE,
// *           'resource' => 'rl1' // OPTIONAL if Authentication is True
// *       ]
// *   ]
// * ];
// *
// */
//return [
//    "prefix" => "/users",
//    "handler" => 'App\Controllers\UsersController',
//    "lazy" => true,
//    "collection" => [
//        "/userlogin" => [
//            'method' => 'post',
//            'function' => 'memberLogin',
//            'authentication' => false,
//            'acl' => 'rl1'
//        ],
//        "/refreshtoken" => [
//            'method' => 'post',
//            'function' => 'refreshtoken',
//            'authentication' => false,
//            'acl' => 'rl1'
//        ],
//        "/initroles" => [
//            'method' => 'post',
//            'function' => 'initializeRoles',
//            'authentication' => false,
//            'acl' => 'rl1'
//        ]
//    ]
//];
