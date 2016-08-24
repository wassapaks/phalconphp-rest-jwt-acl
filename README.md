Phalcon Rest JWT
=================

First of all i wanna give credits to CMOORE, Jeteokefe and Redound for their outstanding Phalcon Rest API Framework, i have learned a lot from your work, i took some of your code integrated them to create my own version of PhalconRest Micro Framework with JWT and ACL.


This project uses Phalcon Micro Framework for REST API with JWT and ACL
---------------------------------------------------

The purpose of this project is to have a base Phalcon REST API framework with JWT and ACL applied. Another purpose also is to apply the best practices done by Cmoore, Jeteokefe and Redound. 

This project idea is a collection of different approaches from the most popular phalcon rest api frameworks created, and with some of my ideas to enhance their existing approaches.

Things i have done: I added an easy to setup routes for each collections separated in each file, a JWT authentication event, and an ACL records checking event for each user, response and request envelopes (request class is from redound) and other functions from other existing phalcon rest frameworks. You may find some of the codes familiar, i have added comments to credit the code owner and also to identify which are my creations.

Using kcachegrind and xdebug to optimize spead and micro framework setup of routes collections. (Caching of routes is not yet available but currently i made a workaround for speed, that will be for next release).



Why do this?
http://www.thebuzzmedia.com/designing-a-secure-rest-api-without-oauth-authentication/

Requirements
---------
PHP 5.4 or greater


Required PHP Modules
- OpenSSL
- Phalcon (http://phalconphp.com/en/download)
- PDO-MySQL
- make

To check for those modules
```bash
$ php -m | egrep "(phalcon|pdo_mysql|openssl)"
phalcon
pdo_mysql
openssl
```

Configuration (Database, URL's, Redis and Others)
--------------
Open  `dist/config/` and and create your own config-<your-extention-name>.php setup your database connection credentials and other configuration credentials

```php
/**
 * Settings to be stored in dependency injector
 */
$settings = array(
    'database' => array(
        'adapter' => 'Mysql',	/* Possible Values: Mysql, Postgres, Sqlite */
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'adminadmin123',
        'name' => 'gn',
        'port' => 3306
    ),
    'application' => array(
        'baseURL' => 'http://pi.loc',
        'apiURL' => 'http://pi.api',
    ),
    'hashkey' => '4a478258bd8e11f4046d6fe49471401893d69469',
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
    'authentication' => "jwt"
);
return $settings;
```


Setup and Installation
--------------

Install ROBO in your system. ( http://robo.li/ )

```bash
robo setup <dev / prod> <migrate-sql / init-only / sqlcommand-only>
```

- Parameter 1 <dev / prod>

Use the name after dash (-) like config-dev.php use "dev"

- Parameter 2 <migrate-sql / init-only / sqlcommand-only>

migrate-sql - executes init.sql and all sql files

init-only - executes ini.sql only (initial database creation)

sql-commands-only - executes sql files except init.sql

if no parameter 2 means database has already been setup

EX:

```bash
robo setup prod init-only
```

Database Migration
-------------

When you want to migrate database only use the following command:

```bash
robo sqlexec <migrate-sql / init-only / sqlcommand-only>
```

To backup your database before executing the sql commands

```bash
robo sqldump
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

With `PHP 5.4`, you can use its builtin web server to quickly test functionality. Make sure to be in the public directory when executing the command below.

```bash
cd apign/public
php -S localhost:8000 ../.htrouter.php
```

Swagger Documentation
-------------
Swagger Document head can be found on `app/config/routes.php`

To add swagger documentation is to add a comment head before your api controller function

Ex GET:
```php
    /**
     * @SWG\Get(
     *     path="/authenticate/get",
     *     summary="Get Authentication",
     *     tags={"Authentication"},
     *     description="Description all",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Check if your bearer token is still valid",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     )
     * )
     *
     */
```

Ex POST:
```php
/**
     * @SWG\Post(
     *     path="/agent/login",
     *     summary="Agent Login",
     *     tags={"Agent"},
     *     description="Login Agent and return token",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Login Credentials",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/AgentLogin")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value"
     *     )
     * )
     *
     * @SWG\Definition(
     *      definition="AgentLogin",
     *      @SWG\Property(property="email", type="string"),
     *      @SWG\Property(property="password", type="string"),
     * )
     */
```

Next Release
-------------

- automatic nginx configuration using robo
- automatic database compare and update using FROM database and TO database
