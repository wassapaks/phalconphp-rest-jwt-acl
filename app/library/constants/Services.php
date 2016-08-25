<?php

namespace PhalconRestJWT\Constants;

/**
 * Class Services
 *
 * Constants Taken from Redound
 *
 *  https://github.com/redound/phalcon-rest-boilerplate
 *
 */

class Services
{
    // Phalcon
    const APPLICATION = "application";
    const ROUTER = "router";
    const URL = "url";
    const REQUEST = "request";
    const RESPONSE = "response";
    const COOKIES = "cookies";
    const FILTER = "filter";
    const FLASH = "flash";
    const EVENTS_MANAGER = "eventsManager";
    const DB = "db";
    const SECURITY = "security";
    const MODELS_MANAGER = "modelsManager";
    const MODELS_METADATA = "modelsMetadata";
    const TRANSACTION_MANAGER = "transactionManager";
    const MODELS_CACHE = "modelsCache";
    const VIEWS_CACHE = "viewsCache";
    const ASSETS = "assets";
    const COLLECTIONS = "collections";
    const CONFIG = "config";

    // PhalconRest
    const AUTH_MANAGER = 'authManager';
    const ACL = 'acl';
    const FRACTAL_MANAGER = 'fractalManager';
    const TOKEN_PARSER = 'tokenParser';
    const QUERY = 'query';
    const USER_SERVICE = 'userService';
    const PHQL_QUERY_PARSER = 'phqlQueryParser';
    const URL_QUERY_PARSER = 'urlQueryParser';
    const ERROR_HELPER = 'errorHelper';
    const FORMAT_HELPER = 'formatHelper';
}

