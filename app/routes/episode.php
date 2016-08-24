<?php


/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

 */
return [
    "prefix" => "/episode",
    "handler" => 'Controllers\EpisodeController',
    "lazy" => true,
    "collection" => [
        $routes[] = [
            'method' => 'post',
            'route' => '/episodeAdd',
            'function' => 'episodeAdd',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/episodeList',
            'function' => 'episodeList',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/episodeInfo',
            'function' => 'episodeInfo',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/episodeUpdate',
            'function' => 'episodeUpdate',
            'authentication' => FALSE
        ],
        [
            'method' => 'post',
            'route' => '/episodeDelete',
            'function' =>  'episodeDelete',
            'authentication' => FALSE
        ]
    ]
];
