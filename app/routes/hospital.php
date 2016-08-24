<?php
/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

 */
return [
    "prefix" => "/hospital",
    "handler" => 'Controllers\HospitalController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'post',
            'route' => '/hospitalAdd',
            'function' => 'hospitalAdd',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/hospitalList',
            'function' => 'hospitalList',
            'authentication' => TRUE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/hospitalInfo',
            'function' => 'hospitalInfo',
            'authentication' => TRUE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/hospitalUpdate',
            'function' => 'hospitalUpdate',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/hospitalDelete',
            'function' => 'hospitalDelete',
            'authentication' => TRUE,
            'resource' => 'rl25'
        ],

        [
            'method' => 'get',
            'route' => '/getHospitalList',
            'function' => 'getHospitalList',
            'authentication' => FALSE
        ]

    ]
];
