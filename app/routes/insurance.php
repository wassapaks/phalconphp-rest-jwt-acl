<?php
/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.
 */
return [
    "prefix" => "/insurance",
    "handler" => 'Controllers\InsuranceController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'post',
            'route' => '/insuranceAdd',
            'function' => 'insuranceAdd',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/insuranceList',
            'function' => 'insuranceList',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/insuranceInfo',
            'function' => 'insuranceInfo',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/insuranceUpdate',
            'function' => 'insuranceUpdate',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ],
        [
            'method' => 'post',
            'route' => '/insuranceDelete',
            'function' => 'insuranceDelete',
            'authentication' => false,
            'resource' => 'rl25'
        ],
        [
            'method' => 'get',
            'route' => '/getInsuranceList',
            'function' => 'getInsuranceList',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ]
    ]
];
