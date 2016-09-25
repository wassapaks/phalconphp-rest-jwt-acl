<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 23/09/2016
 * Time: 2:26 AM
 */

namespace Test\Routes;

use \PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testLogin()
    {
        $service_url = $this->config->application->apiURL. '/news/frontend/latest';

//
//
//        $curl = curl_init($service_url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        $curl_response = curl_exec($curl);
//        if ($curl_response === false) {
//            $info = curl_getinfo($curl);
//            curl_close($curl);
//            die('error occured during curl exec. Additioanl info: ' . var_export($info));
//        }
//        curl_close($curl);
//        $decoded = json_decode($curl_response);

        return 'login';

    }
}