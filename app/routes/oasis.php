<?php
/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.
 */
return [
    "prefix" => "/oasis",
    "handler" => 'Controllers\OasisStartofCareController',
    "lazy" => true,
    "collection" => [
        [
            'method' => 'post',
            'route' => '/oasisStartofCareId',
            'function' => 'generatedId',
            'authentication' => FALSE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/demographicsTemp',
            'function' => 'demographicsTemp',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/demographicsTempSave',
            'function' => 'demographicsTempSave',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/woimagelist',
            'function' => 'woimagelist',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/wouploadimg',
            'function' => 'woUploadimg',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],

    ]
];
