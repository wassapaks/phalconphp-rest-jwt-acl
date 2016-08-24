<?php

/**
 * Settings to be stored in dependency injector
 */

$settings = array(
    'env'=>'dev',
    'database' => array(
        'adapter' => 'Mysql',   /* Possible Values: Mysql, Postgres, Sqlite */
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'adminadmin123',
        'name' => 'dbhcare',
        'port' => 3306
    ),
    'application' => array(
        'baseURL' => 'http://hc.loc',
        'apiURL' => 'http://hc.api',
    ),
    'hashkey' => '4a478258bd8e11f4046d6fe49471401893d69469',
    'tokenEXP' => array(
        'token' => '60 second',
        'refreshToken' => '1 day'
    ),
    'postmark' => array(
        'url' => 'https://api.postmarkapp.com/email',
        'token' => '016e0c8c-d974-491f-b17d-f9c89915ec0a',
        'signature' => 'contact@geeksnest.com'
    ),
    'tokens' => array(
        '82c4cb99-8440-41ef-a6a5-0e81d27b4c5f'
    ),
    'clients' => array(
        'admin' => '48b29b48-cb98-4dab-8a72-69b17fed5b25',
        'agent' => '12b61casdfa1-72b5-42aa-a8a0-e639d18ad4af'
    ),
    'redis' => array(
        'host' => 'localhost',
        'port' => 6379,
        'persistent' => false,
        'sessionkey' => 'pisess',
        'dataexpiration' => 172800
    ),
    'amazonS3' => array(
        'awsAccessKey' => 'AKIAIR3YQHCUALZNBRCA',
        'awsSecretKey' => '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',
        'bucket' => 'planetimpossible',
        'region' => 'us-west-2'
    )
);


return $settings;
