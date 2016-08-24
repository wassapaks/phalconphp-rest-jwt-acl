<?php
/**
 * @author GEEKSNEST fork from Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.
 */
return [
    "prefix" => "/patients",
    "handler" => 'Controllers\PatientController',
    "lazy" => true,
    "collection" => [

        [
            'method' => 'post',
            'route' => '/patientMRN',
            'function' => 'patientMRN',
            'authentication' => FALSE
        ],

        [
            'method' => 'post',
            'route' => '/patientEmail',
            'function' => 'patientEmail',
            'authentication' => FALSE
        ],

        [
            'method' => 'post',
            'route' => '/patientsAdd',
            'function' => 'patientsAdd',
            'authentication' => FALSE,
            'resource' => 'rl25'
        ],
        
        [
            'method' => 'post',
            'route' => '/patientList',
            'function' => 'patientList',
            'authentication' => TRUE,
            'resource' => 'rl25'
        ],

        [
            'method' => 'post',
            'route' => '/patientInfo',
            'function' => 'patientInfo',
            'authentication' => FALSE
        ],

        [
            'method' => 'post',
            'route' => '/patientUpdate',
            'function' => 'patientUpdate',
            'authentication' => TRUE,
            'resource' => 'rl25'
        ],

        [
            'method' => 'post',
            'route' => '/patientDelete',
            'function' => 'deleteMember',
            'authentication' => TRUE,
            'resource' => 'rl50'
        ],

        [
            'method' => 'get',
            'route' => '/getadmissionreqireddata',
            'function' => 'getadmissionreqireddata',
            'authentication' => false,
            'resource' => 'rl50'
        ],
        [
            'method' => 'post',
            'route' => '/patientInfo',
            'function' => 'patientInfo',
            'authentication' => FALSE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/pendingpatientadmit',
            'function' => 'pendingpatientadmit',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'get',
            'route' => '/getPatientEpisopdeInfo/{idpatient}',
            'function' => 'getPatientEpisopdeInfo',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ],
        [
            'method' => 'post',
            'route' => '/saveepisodetask',
            'function' => 'saveEpisodetask',
            'authentication' => TRUE,
            'resource' => 'rl1'
        ]

    ]
];
