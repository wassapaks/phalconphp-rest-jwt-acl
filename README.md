Phalcon Rest JWT
=================

First of all i wanna give credits to [CMOORE](https://github.com/cmoore4), [Jeteokefe](https://github.com/jeteokeeffe) and [Redound](https://github.com/redound) for their outstanding Phalcon Rest API Frameworks, i have learned a lot from your work, i took some of your code integrated them to create my own version of PhalconRest Micro Framework with JWT and ACL.


This project uses Phalcon Micro Framework for REST API with JWT and ACL
---------------------------------------------------

The purpose of this project is to have a base Phalcon REST API framework with JWT and ACL applied. And also to apply some practices done by Cmoore, Jeteokefe and Redound. 

This project idea is a collection of different approaches from the most popular phalcon rest api frameworks created, together with some of my ideas which i thought of enhancements.

Things that i have done: I added an easy to setup routes for each collections separated in each file, a JWT authentication event, and an ACL records checking event for each user, response and request envelopes (request class is from redound). You may find some of the codes familiar, i have added comments to credit the code owner and also to identify which are my creations.

Because phalconphp is all about speed and usability, using kcachegrind and xdebug to check when having a huge large route collection, still works fine but as suggestion in the phalcon documentation use cache. ( Caching of routes is next release.)

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
        'name' => 'dbphalconrest',
        'port' => 3306
    ),
    'application' => array(
        'apiURL' => 'http://phalconrestjwt.api',
        'env' => 'dev' /* dev or prod or maintenance */
    ),
    'hashkey' => 'iknowyouwantmeiknowyoucare',
    'tokenEXP' => array(
        'token' => '30 minutes',
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
```

Setup and Installation
--------------

If you are in Linux or Mac run the setup.sh by passing your config name used from the instruction above

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
Routes are stored in `app/routes/nameRoute.php` as an object. A route has a method (GET, POST, DELETE, PUT, MAP(post or get)).


```php
namespace App\Routes;
use PhalconRestJWT\App\Resources;

class ExampleRoute extends Resources {
    public function initialize()
    {
        $this
            ->handler('App\Controllers\ExampleController')
            ->lazy(true)
            ->collections([
                "/testpost" => [
                    'post',
                    'newnewsample',
                    false,
                    's1',
                ],
                "/testget/{id}" => [
                    'get',
                    'testAction',
                    false,
                    's2'
                ],
                "/authtest" => [
                    'post',
                    'testAuth',
                    false,
                    's3'
                ],
                "/ping" => [
                    'map',
                    'pingAction',
                    true,
                    ['s4', 's2']
                ]
            ]);
    }
}
```

## **Conventions:** ##

1.all in lower case

2.After adding your own route go to ```library/app/bootstrap/CollectionBootstrap.php``` 
```php
$app->resources(UserRoute::init('/route-prefix-here'));
```
place you prefix in the init()

3.On the route Collections ```->collections([])``` is where you should place your routes
```php
[
    "/testpost" => [
        'post',
        'newnewsample',
        false,
        's1',
    ],
    "/ping" => [
        'map',
        'pingAction',
         true,
         ['s4', 's2']
    ]
]
``` 
You key will be the route and the value should be an array with the following format ```[httpMethod, controllerMethod, authenticationRequired, aclRoles]```

4.ACL roles should depend on the roles on your the userroles tables, You can have multiple ACL for a single route. If you check on the userroles you can see roles assign to users, and those roles are attached to an api as well, so it will restrict a user on accessing that API.


Note: For Routes with Paramters, make sure the action you map to has the proper parameters set (in order to read parameters correctly). 
http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes

Example Routes
-------------

1. ```/user/login```

username: superagent
password: 12345678

```php
{
  "status": "success",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjRDMDg1QUY3LUMzMzctNDBCQS1BRTM4LUIwQkVCOTYxRUNBRSIsImVtYWlsIjoiZWZyZW5iYXV0aXN0YWpyQGdtYWlsLmNvbSIsImZpcnN0bmFtZSI6ImVmcmVuIiwibGFzdG5hbWUiOiJiYXV0aXN0YSIsInBpY3R1cmUiOm51bGwsInBlcm1pc3Npb24iOm51bGwsImlhdCI6MTQ3NDgyMjQ5MCwiZXhwIjoxNDc0ODI0MjkwfQ.8R3z7pkqPapDKQDCSA-tcQ-IDRV4Zgb0ultAO0dMtik",
    "refreshtoken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjRDMDg1QUY3LUMzMzctNDBCQS1BRTM4LUIwQkVCOTYxRUNBRSIsImV4cCI6MTQ3NDkwODg5MCwiaWF0IjoxNDc0ODIyNDkwfQ.YC2LXmd80DgN6En7AFFqHMxSTUXYRr0hQCrumQKjC_k",
    "refresh": false
  },
  "message": null
}
```

2. ```/example/testpost```

response in success
```php
{
  "status": "success",
  "data": {
    "asdfaf": "asdfadsf"
  },
  "message": null
}
```

response in exception
```php
{
  "status": "error",
  "data": null,
  "message": "Post Empty",
  "error": {
    "errorMessage": "Post Empty",
    "errorDev": {
      "dev": "Dev Error only appears when dev env is enabled",
      "internalCode": "Example Controller",
      "more": "More error details here"
    }
  }
}
```

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

Test
-------------
Currently working unit testing.

Next Release
-------------

- Route cache