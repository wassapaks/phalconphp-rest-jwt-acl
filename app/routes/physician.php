<?php


/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

 */
return [
    "prefix" => "/physician",
    "handler" => 'Controllers\PhysicianController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'post',
            'route' => '/physicianEmail',
            'function' => 'physicianEmail',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/physicianAdd',
            'function' => 'physicianAdd',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/physicianList',
            'function' => 'physicianList',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/physicianInfo',
            'function' => 'physicianInfo',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/physicianUpdate',
            'function' => 'physicianUpdate',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/PhysicianDelete',
            'function' => 'PhysicianDelete',
            'authentication' => FALSE
        ],
        [
            'method' => 'get',
            'route' => '/getPhysicianList',
            'function' => 'getPhysicianList',
            'authentication' => FALSE
        ],
        [
            'method' => 'get',
            'route' => '/getPhysicianLicense/{license}',
            'function' => 'getPhysicianLicense',
            'authentication' => FALSE
        ]
    ]
];
