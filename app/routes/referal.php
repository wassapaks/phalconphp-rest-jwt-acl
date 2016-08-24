<?php


/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

 */
return [
    "prefix" => "/extreferal",
    "handler" => 'Controllers\ExternalReferalController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'post',
            'route' => '/exRefAdd',
            'function' => 'exRefAdd',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/exRefList',
            'function' => 'exRefList',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/exRefInfo',
            'function' => 'exRefInfo',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/exRefUpdate',
            'function' => 'exRefUpdate',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/exRefDelete',
            'function' => 'exRefDelete',
            'authentication' => FALSE
        ],
        [
            'method' => 'get',
            'route' => '/getExrefList',
            'function' => 'getExrefList',
            'authentication' => FALSE
        ]
    ]
];
