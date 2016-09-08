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
 *           'resource' => 'rl1' // OPTIONAL if Authentication is True
 *       ]
 *   ]
 * ];
 *
 */
return [
    "prefix" => "/members",
    "handler" => 'App\Controllers\MembersController',
    "lazy" => true,
    "collection" => [
        "/checkusername" => [
            'method' => 'post',
            'function' => 'checkusername',
            'authentication' => true,
            'acl' => 'rl1'
        ],
        "/memberlogin" => [
            'method' => 'post',
            'function' => 'memberLogin',
            'authentication' => false,
            'acl' => 'rl1'
        ],
        "/refreshtoken" => [
            'method' => 'post',
            'function' => 'refreshtoken',
            'authentication' => false,
            'acl' => 'rl1'
        ],
        "/initroles" => [
            'method' => 'post',
            'function' => 'initializeRoles',
            'authentication' => false,
            'acl' => 'rl1'
        ],
        "/memberlist/{page}/{keyword}" => [
            'method' => 'get',
            'function' => 'memberList',
            'authentication' => TRUE,
            'acl' => 'rl1'
        ],
        "/deletemember" => [
            'method' => 'post',
            'function' => 'deleteMember',
            'authentication' => TRUE,
            'acl' => 'rl1'
        ],
        "/loadmemberbyid" => [
            'method' => 'post',
            'function' => 'loadMemberbyid',
            'authentication' => TRUE,
            'acl' => 'rl1'
        ],
        "/editmember" => [
            'method' => 'post',
            'function' => 'editMember',
            'authentication' => TRUE,
            'acl' => 'rl1'
        ],
        "/memberuploadfile" => [
            'method' => 'post',
            'function' => 'memberuploadfile',
            'authentication' => TRUE,
            'acl' => 'rl1'
        ]
    ]
];
