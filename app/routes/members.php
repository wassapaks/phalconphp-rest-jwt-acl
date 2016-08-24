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
    "prefix" => "/members",
    "handler" => 'App\Controllers\MembersController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'post',
            'route' => '/checkusername',
            'function' => 'checkusername',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberlogin',
            'function' => 'memberLogin',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/refreshtoken',
            'function' => 'refreshtoken',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/initroles',
            'function' => 'initializeRoles',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/addmember',
            'function' => 'addMember',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/memberlist/{page}/{keyword}',
            'function' => 'memberList',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/deletemember',
            'function' => 'deleteMember',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/loadmemberbyid',
            'function' => 'loadMemberbyid',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/editmember',
            'function' => 'editMember',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberuploadfile',
            'function' => 'memberuploadfile',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/allmemberfilelist',
            'function' => 'allmemberfilelist',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberfilelist',
            'function' => 'memberfilelist',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberfiledelete',
            'function' => 'memberfiledelete',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberedituploadfile',
            'function' => 'memberedituploadfile',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/membercreatefolder',
            'function' => 'membercreatefolder',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberdetelefolder',
            'function' =>  'memberdetelefolder',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/editfolder',
            'function' => 'editfolder',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/memberdownloadfile',
            'function' => 'memberdownloadfile',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/saveroletemplate',
            'function' => 'saveroletemplate',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/loadroletemplatebyid',
            'function' => 'loadroletemplatebyid',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/roletemplatelist',
            'function' => 'roletemplatelist',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/getroletemplate',
            'function' => 'getroletemplate',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/deleteroletemplate',
            'function' => 'deleteroletemplate',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/editroletemplate',
            'function' => 'editroletemplate',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/getMemberList',
            'function' => 'getMemberList',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/loadprofile',
            'function' => 'loadprofile',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/updateprofile',
            'function' => 'updateprofile',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/changepassword',
            'function' => 'changepassword',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/addsecurityquestion',
            'function' => 'addSecurityQuestion',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/loginstatus/{memberid}',
            'function' => 'loginstatus',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/getsecurityquestion/{memberid}',
            'function' => 'getsecurityquestion',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/getroleitems',
            'function' => 'getRoleitemsCb',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/checkemail',
            'function' => 'checkEmail',
            'authentication' => FALSE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/checkusername',
            'function' => 'checkUsername',
            'authentication' => FALSE,
            'resource' => 'rl1'
        ]
    ]
];
