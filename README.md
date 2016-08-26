Phalcon Rest JWT
=================

First of all i wanna give credits to CMOORE, Jeteokefe and Redound for their outstanding Phalcon Rest API Frameworks, i have learned a lot from your work, i took some of your code integrated them to create my own version of PhalconRest Micro Framework with JWT and ACL.


This project uses Phalcon Micro Framework for REST API with JWT and ACL
---------------------------------------------------

The purpose of this project is to have a base Phalcon REST API framework with JWT and ACL applied. And also to apply the best practices done by Cmoore, Jeteokefe and Redound. 

This project idea is a collection of different approaches from the most popular phalcon rest api frameworks created, and with some of my ideas to enhance their existing approaches.

Things that i have done: I added an easy to setup routes for each collections separated in each file, a JWT authentication event, and an ACL records checking event for each user, response and request envelopes (request class is from redound) and other functions from other existing phalcon rest frameworks. You may find some of the codes familiar, i have added comments to credit the code owner and also to identify which are my creations.

Because phalconphp is all about speed and usability, using kcachegrind and xdebug to optimize the micro route collection setup when having a large route collection. ( Caching of routes is not yet available but currently i made a workaround for speed, that will be for next release).


Why do this?
http://www.thebuzzmedia.com/designing-a-secure-rest-api-without-oauth-authentication/

Requirements
---------
-PHP 5.4 above until 7
-Phalconphp 2 until 3
-PDO-MySQL

Configuration (Database, URL's, Redis and Others)
--------------
Open  `/app/config/` and and create your own config.<your-desired-name>.php setup your database connection credentials and other configuration credentials

Change the env ```env => 'dev'``` to prod when your on the production server.

```php
$settings = array(
    'database' => array(
        'adapter' => 'Mysql',   /* Possible Values: Mysql, Postgres, Sqlite */
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'adminadmin123',
        'name' => 'dbsample',
        'port' => 3306
    ),
    'application' => array(
        'baseURL' => 'http://youreSITEipordomain',
        'apiURL' => 'http://youreRESTipordomain',
        'env' => 'dev' /* dev or prod */
    ),
    'hashkey' => 'iknowyouwantmeiknowyoucare',
    'tokenEXP' => array(
        'token' => '60 second',
        'refreshToken' => '1 day'
    )
    // 'redis' => array(
    //     'host' => 'localhost',
    //     'port' => 6379,
    //     'persistent' => false,
    //     'sessionkey' => 'redissess',
    //     'dataexpiration' => 172800
    // )
);
```


Setup and Installation
--------------

If you are in Linux or Mac run the setup.sh by passing your config name in used in the <your-desired-name>

Example:

```bash
bash setup.sh ef
```

You can setup it manually:

1. by copying your configuration in dist/config into the app/config
2. change the value of the APP_ENV in the public/index.php to youre-desired-name in your config filename
3. create a cache folder in app because it is being ignored by .gitignore

Database Migration
-------------

When you want to migrate database only use the following command:

```bash 
bash migratesql.sh <host> <username> <password> <type> <databasename>
```

Routes
-------------
Routes are stored in `app/routes/routesname.php` as a return array. A route has a method (HEAD, GET, POST, PATCH, DELETE, OPTIONS), uri (which can contain regular expressions) and handler/controller to point to.

Conventions:

1. All lower case
2. prefix should be the module name
3. ACL should depend on the roles on the database, for the moment you can have all the same

```php

return [
    "prefix" => "/members",
    "handler" => 'Controllers\MembersController',
    "lazy" => true,
    "collection" => [
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
            'authentication' => TRUE,
            'resource' => 'rl1' //ACL Rules
        ]
    ]
];
```

Note: For Routes with Paramters, make sure the action you map to has the proper parameters set (in order to read paramters correctly). 
http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes

Client Requirements
-------------
PHP 5.3+

Required PHP Modules
- Curl (http://php.net/curl)

To check for that module
```bash
$ php -m | grep -i "curl"
curl
```

Server Test
-------------


Next Release
-------------

- fixing ACL
- applying multiple assignment to a single route