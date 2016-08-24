<?php
namespace PhalconRestJWT\Http;

use PhalconRestJWT\Constants\Services,
    PhalconRestJWT\Exceptions\Http;

class Response extends \Phalcon\Http\Response{

    protected $snake = true;

    protected $envelope = true;


    public function sendContent($records, $error=false){

        $status = 'success';
        $type = 'content';
        $res = [
            'status'    => $status,
            'data'      => null,
            'message'   => null
        ];

        // Error's come from HTTPException.  This helps set the proper envelope data
        if($error){
            //check if no error header PUT IT HERE
            if(isset($records['errorHeader'])){
                $this->setStatusCode(
                    $records['errorHeader']['statusCode'], 
                    $records['errorHeader']['message']
                );
                unset($records['errorHeader']);
            }
            if($this->getDi()->get(Services::CONFIG)['application']['env'] !== 'dev')
                    unset($records['errorDev']);
            
            
            $status="error";
            $res['message'] = $records['errorMessage'];
            $res['data'] = $records;
        }else{
            $res['data'] = $records;
        }

        if( isset($records['ApiStatus']) ) {
            $this->setStatusCode(
                $records['ApiStatus'], 
                $this->getResponseDescription($records['ApiStatus'])
            );
            unset($records['ApiStatus']);
        }

        $etag = md5(serialize($records));

        $res['status'] = $status;

        $this->setContentType('application/json', 'UTF-8');
        $this->setEtag($etag);
        $this->setJsonContent($res);
        $this->send();

    }

    protected function getResponseDescription($code)
    {
        $codes = array(

            // Informational 1xx
            100 => 'Continue',
            101 => 'Switching Protocols',

            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

            // Redirection 3xx
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',  // 1.1
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            // 306 is deprecated but reserved
            307 => 'Temporary Redirect',

            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',

            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded'
        );

        $result = (isset($codes[$code])) ?
            $codes[$code]          :
            'Unknown Status Code';

        return $result;
    }
}