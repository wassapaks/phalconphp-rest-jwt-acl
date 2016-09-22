<?php

namespace PhalconRestJWT\Constants;

/**
 * Class HttpMethods
 *
 * Constants Taken from Redound but added somethings i need
 *
 *  https://github.com/redound/phalcon-rest-boilerplate
 *
 */

class HttpMethods
{
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";
    const HEAD = "HEAD";
    const OPTIONS = "OPTIONS";
    const PATCH = "PATCH";

    const ALL_METHODS = [self::GET, self::POST, self::PUT, self::DELETE, self::HEAD, self::OPTIONS, self::PATCH];
}
