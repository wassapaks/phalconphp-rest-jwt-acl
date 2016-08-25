<?php

namespace App\Controllers;

use App\Models\Members,
    PhalconRestJWT\Exceptions\Http;

class ExampleController extends \Phalcon\Mvc\Controller {

    public function newnewsample(){
        
        // throw new Http(1010, 'Something went Wrong',
        //     array(
        //         'dev' => "adsfadsfadsf",
        //         'internalCode' => "EXC002",
        //         'more' => "aSDasd"
        //     )
        // );
        
        $res = Members::find();
        $data = $res->toArray();
        return $data;
    }

	public function pingAction() {
		// $S3 = CB::S3initalize();
		// $request = new \Phalcon\Http\Request();
		// $file   = $request->getPost('file');

		// $getobject = S3::putObject('', $S3->bucket, 'uploads/memberfiles/asdsad/', S3::ACL_PUBLIC_READ);
		// $getobject = S3::getObject($S3->bucket, 'uploads/memberfiles/dbhcare.sql');
		// $getobject = S3::copyObject($S3->bucket, 'uploads/memberfiles/44B11111-0A6F-422B-B323-1CBF7751B9F2/ggggggggg/zxccccccccccccc/', $S3->bucket, 'uploads/memberfiles/rain/ggggggggg/zxccccccccccccc/', $metaHeaders = array(), $requestHeaders = array());
		// var_dump($getobject->headers['type']);
		// header('Content-Description: File Transfer');
    	//this assumes content type is set when uploading the file.
		// header('Content-Type: ' . $getobject->headers['type']);
		// header('Content-Disposition: attachment; filename=' . 'dbhcare.sql');
		// header('Expires: 0');
		// header('Cache-Control: must-revalidate');
		// header('Pragma: public');
        // throw new \Micro\Exceptions\HTTPExceptions(
        //     "this is an error",
        //     405,
        //     array(
        //         'dev' => "adsfadsfadsf",
        //         'internalCode' => "EXC001",
        //         'more' => "aSDasd"
        //     )
        // );

        return array('asdasd'=>'asd');
		// echo $getobject->body;
		// if($getobject){
		// 	echo $S3->bucket;
		// }
		// else{
		// 	echo 'false';
		// }

//        $emailcontent['username'] = 'hartjo';
//        $emailcontent['password'] = CB::randomPassword();
//        $emailcontent['token'] = CB::randomPassword();
//        $email = EM::mailTemplate($emailcontent);
//        echo $email;

        throw new \Micro\Exceptions\HTTPExceptions(
            "this is an error",
            406,
            array(
                'dev' => "adsfadsfadsf",
                'internalCode' => "EXC002",
                'more' => "aSDasd"
            )
        );

        return $data;

	}

    public function testAuth($name){
        $data = array($name,'ResponseCode' => 202);
        return $data;
    }

    public function testAction($id) {
        echo "test (id: $id)";
    }

    public function skipAction($name) {
        echo "auth skipped ($name)";
    }

    public function samplequery(){

        // $sample = CB::createBuilder()
        // ->columns(array('Models\Membersdirectory.directoryid','Models\Membersfile.filepath'))
        // ->from('Models\Membersdirectory')
        // ->leftJoin('Models\Membersfile', 'Models\Membersdirectory.contentpath = Models\Membersfile.filepath')
        // ->where('Models\Membersdirectory.directoryid = "8CE049B1-3D42-4FF5-A121-98AA3EEBECE7"')
        // ->getQuery()
        // ->execute();

        // $sample = CB::createBuilder()
        // ->from('Models\Membersdirectory')
        // ->getQuery()
        // ->execute();

        // $sample = CB::customQuery('SELECT * FROM membersdirectory');

        // echo json_encode($sample->toArray());
    }

    public function examplepost() {

    }

    public function exampleget() {

    }

}
