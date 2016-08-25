<?php

/**
 * Settings to be stored in dependency injector
 */

$settings = array(
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
        'env' => 'dev' /* dev or prod */
    ),
    'hashkey' => 'iknowyouwantmeiknowyoucare',
    'tokenEXP' => array(
        'token' => '30 second',
        'refreshToken' => '1 day'
    )
    // 'redis' => array(
    //     'host' => 'localhost',
    //     'port' => 6379,
    //     'persistent' => false,
    //     'sessionkey' => 'pisess',
    //     'dataexpiration' => 172800
    // )
);

return $settings;
