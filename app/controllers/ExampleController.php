<?php

namespace App\Controllers;

use App\Models\Users;
use PhalconRestJWT\Exceptions\Http;

class ExampleController extends ControllerBase {

    public function sampleData(){
        $res = Users::find();
        $data = $res->toArray();
        return $data;
    }

	public function samplePost() {

        if(empty($this->request->getPost())){
            throw new Http(1010, 'Post Empty',
                 array(
                     'dev' => "Dev Error only appears when dev env is enabled",
                     'internalCode' => "EXC-12",
                     'more' => "More error details here"
                 )
            );
        }

        return array("ApiStatus"=>201,$this->request->getPost());

	}

    public function testAuth(){
        return array("Route with authentication using MAP");
    }

    public function testGet($message) {
        return array($message);
    }

    public function test($message) {
        return array($message);
    }

    public function testtestrouters() {
        return ["testing"];
    }

    public function testacl() {
        return array("You are able to get in");
    }

}
