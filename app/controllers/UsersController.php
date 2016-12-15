<?php

namespace App\Controllers;

use PhalconRestJWT\Security\AclRoles;
use App\Models\Users;

class UsersController extends ControllerBase{

    public function userLogin(){

        if($this->request->isPost()){

            $username   = $this->request->getPost('username');
            $password   = $this->request->getPost('password');

            $data = $this->userService->authorizeUser(array("username"=>$username,"password"=>$password), "Users");

        }

        return $data;

    }

    public function refreshtoken(){

        $errorState = '';
        if($this->request->isPost()){

            $rtoken   = $this->request->getPost('refresh');

            $decoded = \Firebase\JWT\JWT::decode($rtoken, $this->config["hashkey"], array('HS256'));

            return $this->User->authorizeUser(array('memberid'=>$decoded->id),'Users', true);

        }

        $this->ErrorMessage->recNotFound("MEM-RT");

    }

    public function initializeRoles(){

        //
        // Things to do for ACL
        // 1. Make ACL roles multiple for each API
        // 2. Make an Add Role ACL module instead of recreating everything,
        // 3. Create an API for recalibrating the ACL Roles
        // 4. Each user must have a Cache ACL Role

        $own = Users::findFirst(
            array(
                "userLevel = 'OWNER'",
                "columns" => "userid"
            ));

         $rolesResources = array($own->userid => array());
         $users = array($own->userid);
         $collections = $this->di->getShared('collections');

        $rec = new Users();

         foreach($collections as $col){
             foreach($col['collection'] as $colh) {
                 $controller = str_replace('App\Controllers\\','',$col['handler']);
                 if( isset($colh[1]) ){
                     $rolesResources[$own->userid][$controller][] = $colh[1];
                 }

                 foreach($rec->userAndRoles() as $r){

                     $currentRole = false;
                     if(isset($colh[3])){
                         if(is_array($colh[3])){
                             $currentRole = in_array($r->role , $colh[3]);
                         }else{
                             $currentRole = $colh[3] == $r->role ? true : false;
                         }
                     }

                     if($currentRole && $r->userid != $own->userid) {
                         if(!isset($rolesResources[$r->userid])){
                             $users[] = $r->userid;
                         }
                         $rolesResources[$r->userid][$controller][] = $colh[1];
                     }
                 }
             }
         }

        $data = array(AclRoles::setAcl($rolesResources,$users) ? "Successfully created your roles!": "Something went wrong");

        return $data;

    }

//
//    public function addMember(){
//
//        $request = new Request();
//        $manager = new TxManager();
//        $transaction = $manager->get();
//        $guid = new Guid();
//
//
//        if($request->isPost()){
//
//            $memberid       = $guid->GUID();
//            $username       = $request->getPost('username');
//            $email          = $request->getPost('email');
//            $password       = CB::randomPassword();
//            $firstname      = $request->getPost('firstname');
//            $lastname       = $request->getPost('lastname');
//            $suffix         = $request->getPost('suffix');
//            $birthdate      = $request->getPost('birthdate');
//            $gender         = $request->getPost('gender');
//            $credential     = $request->getPost('credential');
//            $title          = $request->getPost('title');
//            $employeetype   = $request->getPost('employeetype');
//            $ssn            = $request->getPost('ssn');
//            $employeeid     = $request->getPost('employeeid');
//            $address1       = $request->getPost('address1');
//            $address2       = $request->getPost('address2');
//            $city           = $request->getPost('city');
//            $state          = $request->getPost('state');
//            $zip            = $request->getPost('zip');
//            $phone          = $request->getPost('phone');
//            $mobile         = $request->getPost('mobile');
//            $picture        = $request->getPost('picture');
//            $roles          = $request->getPost('roles');
//
//            try {
//
//                $savemember = new Users();
//                $savemember->setTransaction($transaction);
//
//                $savemember->memberid       = $memberid;
//                $savemember->username       = $username;
//                $savemember->email          = $email;
//                $savemember->password       = sha1($password);
//                $savemember->firstname      = $firstname;
//                $savemember->lastname       = $lastname;
//                $savemember->suffix         = $suffix;
//                $savemember->birthdate      = $birthdate;
//                $savemember->gender         = $gender;
//                $savemember->credential     = $credential;
//                $savemember->title          = $title;
//                $savemember->employeetype   = $employeetype;
//                $savemember->ssn            = $ssn;
//                $savemember->employeeid     = $employeeid;
//                $savemember->address1       = $address1;
//                $savemember->address2       = $address2;
//                $savemember->city           = $city;
//                $savemember->state          = $state;
//                $savemember->zip            = $zip;
//                $savemember->phone          = $phone;
//                $savemember->mobile         = $mobile;
//                $savemember->picture        = $picture;
//                $savemember->datecreated    = date('Y-m-d H:i:s');
//
//                if(!$savemember->save()){
//                    // $errors = CB::geterrormessage($savemember);
//                    // $data = array('error' => 'Something went wrong!', 'statuscode' => $errors );
//                    $transaction->rollback();
//
//                }
//
//                $savelogininfo = new Logininfo();
//                $savelogininfo->setTransaction($transaction);
//
//                $savelogininfo->memberid = $memberid;
//                $savelogininfo->status = 'first';
//
//                if(!$savelogininfo->save()){
//                    $transaction->rollback();
//                }
//
//                foreach ($roles as $rolesvalue) {
//                    $savememberroles = new Userroles();
//                    $savememberroles->setTransaction($transaction);
//
//                    $savememberroles->memberid  = $memberid;
//                    $savememberroles->role      = $rolesvalue;
//
//                    if(!$savememberroles->save()){
//
//                        // $errors = CB::geterrormessage($savememberroles);
//                        // $data = array('error' => 'Something went wrong!', 'statuscode' => $errors );
//                        $transaction->rollback();
//
//                    }
//                }
//
//
//                //save data to database if there is no error
//                $transaction->commit();
//
//                //send account information to user via email
//                $emailcontent['username'] = $username;
//                $emailcontent['password'] = $password;
//                $emailbody = EM::mailTemplate($emailcontent);
//
//                EM::sendMail($email, 'Medisource :Account Login Information', $emailbody);
//
//                //success message
//                $data = array('success' => 'Member saved!', 'statuscode' => 200 );
//
//
//            }
//            catch (TxFailed $e) {
////                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//                throw new \Micro\Exceptions\HTTPExceptions(
//                    "this is an error",
//                    406,
//                    array(
//                        'dev' => "adsfadsfadsf",
//                        'internalCode' => "EXC002",
//                        'more' => "aSDasd"
//                    )
//                );
//            }
//
//
//
//        }
//
//        return $data;
//
//    } //end of addMember fucntion
//
//
//    public function checkUsername(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $username = $request->getPost('username');
//
//            $checkusername =  Members::findFirst("username = '".$username."'");
//            if($checkusername){
//                $data = array('error' => 'Username is already exist!', 'statuscode' => 409 );
//            }
//            else{
//                $data = array('success' => 'Username is available', 'ResponseCode' => 200 );
//            }
//
//        }
//
//        return $data;
//    }
//
//
//    public function checkEmail(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $email = $request->getPost('email');
//
//            $checkemail =  Members::findFirst("email = '".$email."'");
//            if($checkemail){
//                $data = array('error' => 'Email is already exist!', 'statuscode' => 409 );
//            }
//            else{
//                $data = array('success' => 'Email is available!', 'statuscode' => 200 );
//            }
//
//        }
//
//        return $data;
//
//    }
//
//
//
//    public function memberList(){
//
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $keyword   = $request->getPost('keyword');
//            $page      = $request->getPost('page');
//            $offset = ($page * 10) - 10;
//
//            $query = [
//                'cols'=> ["memberid","username","email", "firstname", "lastname"],
//                'after_statements'=> "ORDER BY datecreated DESC LIMIT ".( $offset < 0 ? 0 : $offset ).",10",
//                'params' => null
//            ];
//
//            if ($keyword) {
//
//                $query['conditions'] = " firstname LIKE :keyword OR lastname LIKE :keyword OR email LIKE :keyword ";
//                $query['params'] = array("keyword" => '%'.$keyword.'%');
//
//            }
//
//            $memberresults = Members::recordList($query);
//        }
//
//        $data = array('memberresults'=> $memberresults->toArray(), 'memberresultscount' => $memberresults->count(), 'page' => $page);
//
//        return $data;
//
//    } //end of memberlist fucntion


//    public function deleteMember(){
//
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid   = $request->getPost('memberid');
//
//            $member = Members::findFirst("memberid = '". $memberid ."'");
//
//            if($member){
//                if($member->delete()){
//                    $data = array('success' => 'Member successfully deleted!', 'statuscode' => 200 );
//                }
//                else{
//                    $data = array('error' => 'Something went wrong!', 'statuscode' => 400 );
//                }
//            }
//            else{
//                $data = array('error' => 'Something went wrong!', 'statuscode' => 400 );
//            }
//
//            return $data;
//        }
//
//    } //end of deletemember fucntion
//
//
//    public function loadMemberbyid(){
//
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid   = $request->getPost('memberid');
//
//
//
//            $member = CB::customQueryFirst("SELECT memberid,
//            username,
//            email,
//            firstname,
//            lastname,
//            suffix,
//            birthdate,
//            gender,
//            credential,
//            title,
//            employeetype,
//            ssn,
//            employeeid,
//            address1,
//            address2,
//            city,
//            state,
//            zip,
//            phone,
//            mobile,
//            picture FROM members WHERE memberid = '".$memberid."'");
//
//            $memberroles = CB::customQuery("SELECT role FROM memberroles WHERE memberid = '".$memberid."'");
//
//            if($member){
//                $data = array('memberdata' => $member, 'roles' => $memberroles, 'roleitems' => self::getRoleitems());
//            }
//            else{
//                $data = array('error' => 'Something went wrong!', 'statuscode' => 400 );
//            }
//            return $data;
//        }
//
//    } //end of loadmemberbyid fucntion
//
//
//    public function editMember(){
//
//        $manager = new TxManager();
//        $transaction = $manager->get();
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid       = $request->getPost('memberid');
//            $username       = $request->getPost('username');
//            $email          = $request->getPost('email');
//            $password       = $request->getPost('password');
//            $firstname      = $request->getPost('firstname');
//            $lastname       = $request->getPost('lastname');
//            $suffix         = $request->getPost('suffix');
//            $birthdate      = $request->getPost('birthdate');
//            $gender         = $request->getPost('gender');
//            $credential     = $request->getPost('credential');
//            $title          = $request->getPost('title');
//            $employeetype   = $request->getPost('employeetype');
//            $ssn            = $request->getPost('ssn');
//            $employeeid     = $request->getPost('employeeid');
//            $address1       = $request->getPost('address1');
//            $address2       = $request->getPost('address2');
//            $city           = $request->getPost('city');
//            $state          = $request->getPost('state');
//            $zip            = $request->getPost('zip');
//            $phone          = $request->getPost('phone');
//            $mobile         = $request->getPost('mobile');
//            $picture        = $request->getPost('picture');
//            $roles          = $request->getPost('roles');
//
//            try {
//
//                $member = Members::findFirst("memberid = '". $memberid ."'");
//                $member->setTransaction($transaction);
//
//                if($member){
//
//                    $member->username       = $username;
//                    $member->email          = $email;
//                    $member->firstname      = $firstname;
//                    $member->lastname       = $lastname;
//                    $member->suffix         = $suffix;
//                    $member->birthdate      = $birthdate;
//                    $member->gender         = $gender;
//                    $member->credential     = $credential;
//                    $member->title          = $title;
//                    $member->employeetype   = $employeetype;
//                    $member->ssn            = $ssn;
//                    $member->employeeid     = $employeeid;
//                    $member->address1       = $address1;
//                    $member->address2       = $address2;
//                    $member->city           = $city;
//                    $member->state          = $state;
//                    $member->zip            = $zip;
//                    $member->phone          = $phone;
//                    $member->mobile         = $mobile;
//                    $member->picture        = $picture;
//
//                    if(!$member->save()){
//                        // $errors = CB::geterrormessage($member);
//                        // $data = array('error' => 'Something went wrong!', 'statuscode' => $errors );
//                        $transaction->rollback();
//                    }
//
//                }
//
//
//                $deletememberrole = Memberroles::find("memberid = '". $memberid ."'");
//
//                if($deletememberrole){
//                    if(!$deletememberrole->delete()){
//                        // $errors = CB::geterrormessage($deletememberrole);
//                        // $data = array('error' => 'Something went wrong!', 'statuscode' => $errors );
//                        $transaction->rollback();
//                    }
//                }
//
//
//                foreach ($roles as $rolesvalue) {
//                    $savememberroles = new Memberroles();
//                    $savememberroles->setTransaction($transaction);
//
//                    $savememberroles->memberid  = $memberid;
//                    $savememberroles->role      = $rolesvalue;
//
//                    if(!$savememberroles->save()){
//
//                        // $errors = CB::geterrormessage($savememberroles);
//                        // $data = array('error' => 'Something went wrong!', 'statuscode' => $errors );
//                        $transaction->rollback();
//
//                    }
//                }
//
//
//                $transaction->commit();
//                $data = array('success' => 'Member successfully updated!', 'statuscode' => 200 );
//
//
//            }
//            catch (TxFailed $e) {
//                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//            }
//
//            return $data;
//        }
//
//    } //end of editmember fucntion

//
//    public function memberuploadfile(){
//        $request = new Request();
//        $guid = new Guid();
//
//        if($request->isPost()){
//
//            $fileid             = $guid->GUID();
//            $memberid           = $request->getPost('memberid');
//            $filetitle          = $request->getPost('filetitle');
//            $filedescription    = $request->getPost('filedescription');
//            $filename           = $request->getPost('filename');
//            $filetypes          = $request->getPost('filetype');
//            $fileextension      = $request->getPost('fileextension');
//            $filepath           = $request->getPost('path');
//            $filetype           = explode("/",$filetypes);
//
//            $checktitle = Membersfile::findFirst("filetitle = '".$filetitle."'");
//            if($checktitle) {
//                $data = array('conflict' => 'Something went wrong! File Title is already exist', 'statuscode' => 409 );
//            }
//            else {
//                $savefile                   = new Membersfile();
//                $savefile->fileid           = $fileid;
//                $savefile->memberid         = $memberid;
//                $savefile->filetitle        = $filetitle;
//                $savefile->filedescription  = $filedescription;
//                $savefile->filepath         = $filepath;
//                $savefile->filename         = $filename;
//                $savefile->filetype         = $filetype[0];
//                $savefile->fileextension    = $fileextension;
//                $savefile->datecreated      = date('Y-m-d H:i:s');
//
//                if($savefile->save()){
//                    $data = array('success' => 'File saved!', 'statuscode' => 200 );
//                }
//                else{
//                    $errors = array();
//                    foreach ($savefile->getMessages() as $message) {
//                        $errors[] = $message->getMessage();
//                    }
//                    $data['err'] = $errors;
//                    $data = array('error' => 'Something went wrong!', 'statuscode' => $errors );
//                }
//            }
//        }
//
//        return $data;
//
//    } //end of memberuploadfile fucntion
//
//
//    public function allmemberfilelist(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $keyword   = $request->getPost('keyword');
//            $page      = $request->getPost('page');
//            $sortby  = explode("/",$request->getPost('sortby'));
//            $offset = ($page * 10) - 10;
//
//            if ($keyword == 'null' || $keyword == 'undefined' || $keyword == '') {
//
//                $membersfileresults = CB::customQuery("SELECT * FROM membersfile ORDER BY ".$sortby[0]." ".$sortby[1]."  LIMIT " . $offset . ",10");
//
//                $membersfilecount = CB::customQuery("SELECT count(fileid) as total FROM membersfile");
//
//            }
//            else{
//
//                $membersfileresults = CB::customQuery("SELECT * FROM membersfile WHERE filetitle LIKE '%".$keyword."%' OR filedescription LIKE '%".$keyword."%' OR filename LIKE '%".$keyword."%' OR filetype LIKE '%".$keyword."%' ORDER BY ".$sortby[0]." ".$sortby[1]."  LIMIT " . $offset . ",10");
//
//                $membersfilecount = CB::customQuery("SELECT count(fileid) as total FROM membersfile WHERE filetitle LIKE '%".$keyword."%' OR filedescription LIKE '%".$keyword."%' OR filename LIKE '%".$keyword."%' OR filetype LIKE '%".$keyword."%'");
//
//            }
//
//        }
//
//        $data = array(['membersfileresults'=> $membersfileresults, 'membersfileresultscount' => $membersfilecount[0]['total'], 'page' => $page]);
//
//        return $data;
//
//    } //end of allmemberfilelist function
//
//
//    public function memberfiledelete(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $fileid   = $request->getPost('fileid');
//            $memberid   = $request->getPost('memberid');
//
//            $deletefile = Membersfile::findFirst("fileid = '".$fileid."' AND memberid = '". $memberid ."'");
//
//            if($deletefile){
//                if($deletefile->delete()){
//                    $data = array('success' => 'File Deleted!', 'statuscode' => 200 );
//                }
//                else{
//                    $data = array('error' => 'Something went wrong!', 'statuscode' => 400 );
//                }
//            }
//            else{
//                $data = array('error' => 'Something went wrong!', 'statuscode' => 400 );
//            }
//
//            return $data;
//
//        }
//    } //end of memberfiledelete function
//
//
//    public function memberedituploadfile(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $fileid             = $request->getPost('fileid');
//            $memberid           = $request->getPost('memberid');
//            $filetitle          = $request->getPost('filetitle');
//            $filedescription    = $request->getPost('filedescription');
//            $filename           = $request->getPost('filename');
//            $filetypes          = $request->getPost('filetype');
//            $fileextension      = $request->getPost('fileextension');
//            $editmode           = $request->getPost('editmode');
//            $filetype           = explode("/",$filetypes);
//
//            $updatefile = Membersfile::findFirst("fileid = '".$fileid."' AND memberid = '". $memberid ."'");
//
//            if($updatefile){
//
//                if($editmode == 'withfile'){
//                    $updatefile->filetitle        = $filetitle;
//                    $updatefile->filedescription  = $filedescription;
//                    $updatefile->filename         = $filename;
//                    $updatefile->filetype         = $filetype[0];
//                    $updatefile->fileextension    = $fileextension;
//                }
//                else{
//                    $updatefile->filetitle        = $filetitle;
//                    $updatefile->filedescription  = $filedescription;
//                }
//
//
//                if($updatefile->save()){
//                    $data = array('success' => 'File updated!', 'statuscode' => 200 );
//                }
//                else{
//                    $data = array('error' => 'Something went wrong!', 'statuscode' => 400 );
//                }
//
//            }
//            else{
//                $data = array('error' => $updatefile, 'statuscode' => 400 );
//            }
//
//        }
//
//        return $data;
//
//    } //end of memberedituploadfile function
//
//
//    public function membercreatefolder(){
//        $request = new Request();
//        $guid = new Guid();
//        $transactionManager = new TxManager();
//        $transaction = $transactionManager->get();
//
//        if($request->isPost()){
//
//            $directoryid    = $guid->GUID();
//            $memberid       = $request->getPost('memberid');
//            $directorytitle = $request->getPost('directorytitle');
//            $directorypath  = $request->getPost('path');
//            if($directorypath == '/'){
//                $contentpath = '/'.$guid->GUID();
//            }
//            else{
//                $contentpath = $directorypath.'/'.$guid->GUID();
//            }
//
//            $findfolder = Membersdirectory::findFirst("directorytitle = '".$directorytitle."' AND directorypath = '". $directorypath ."'");
//            if($findfolder){
//                $data = array('error' => 'Folder is already exist!', 'statuscode' => 400 );
//            }
//            else{
//
//                try {
//                        $savefolder = new Membersdirectory();
//                        $savefolder->setTransaction($transaction);
//
//                        $savefolder->directoryid    = $directoryid;
//                        $savefolder->memberid       = $memberid;
//                        $savefolder->directorytitle = $directorytitle;
//                        $savefolder->directorypath  = $directorypath;
//                        $savefolder->contentpath    = $contentpath;
//                        $savefolder->datecreated    = date('Y-m-d H:i:s');
//
//                        if(!$savefolder->save()){
//                            $errors = $this->geterrormessage($savefolder);
//                            $transaction->rollback();
//                        }
//
//                        $transaction->commit();
//                        $data = array('success' => 'New folder successfully created!', 'statuscode' => 200 );
//
//                    }
//
//                    catch (TxFailed $e) {
//                        $data = array('error' => $errors, 'statuscode' => 400 );
//                    }
//
//            }
//
//            return $data;
//
//        }
//
//    } //end of membercreatefolder function
//
//
//    public function memberfilelist(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $keyword   = $request->getPost('keyword');
//            $page      = $request->getPost('page');
//            $path      = $request->getPost('path');
//            $memberid  = $request->getPost('memberid');
//            $sortby  = explode("/",$request->getPost('sortby'));
//            $offset = ($page * 10) - 10;
//            $membersfilearray = array();
//
//            if ($keyword == 'null' || $keyword == 'undefined' || $keyword == '') {
//
//                $membersfileresults = CB::customQuery("SELECT * FROM(
//                    SELECT fileid as sid, memberid as smemberid, filetitle as stitle, filedescription as sdesc, filepath as spath, 'dummy' as scontentpath,  filename as sfilename, filetype as stype, fileextension as sext, dateedited as sdateedited, datecreated as sdatecreated FROM membersfile
//                    UNION
//                    SELECT directoryid as sid, memberid as smemberid, directorytitle as stitle, 'dummy' as sdesc, directorypath as spath,  contentpath as scontentpath, 'dummy' as sfilename, 'folder' as stype, 'folder' as sext, dateedited as sdateedited, datecreated as sdatecreated FROM membersdirectory
//                    )
//                    AS searchtable WHERE smemberid = '".$memberid."' and spath = '".$path."' ORDER BY ".$sortby[0]." ".$sortby[1]." LIMIT " . $offset . ",10");
//
//                $membersfilecount = CB::customQuery("SELECT count(sid) as total FROM(
//                    SELECT fileid as sid, memberid as smemberid, filepath as spath FROM membersfile
//                    UNION
//                    SELECT directoryid as sid, memberid as smemberid, directorypath as spath FROM membersdirectory
//                    )
//                    AS searchtable WHERE smemberid = '".$memberid."' and spath = '".$path."'");
//
//            }
//            else{
//
//                $membersfileresults = CB::customQuery("SELECT * FROM(
//                    SELECT fileid as sid, memberid as smemberid, filetitle as stitle, filedescription as sdesc, filepath as spath, 'dummy' as scontentpath,  filename as sfilename, filetype as stype, fileextension as sext, dateedited as sdateedited, datecreated as sdatecreated FROM membersfile
//                    UNION
//                    SELECT directoryid as sid, memberid as smemberid, directorytitle as stitle, 'dummy' as sdesc, directorypath as spath,  contentpath as scontentpath, 'dummy' as sfilename, 'folder' as stype, 'folder' as sext, dateedited as sdateedited, datecreated as sdatecreated FROM membersdirectory
//                    )
//                    AS searchtable WHERE smemberid = '".$memberid."' AND stitle LIKE '%".$keyword."%' OR smemberid = '".$memberid."' AND stype LIKE '%".$keyword."%' ORDER BY ".$sortby[0]." ".$sortby[1]."  LIMIT " . $offset . ",10");
//
//                $membersfilecount = CB::customQuery("SELECT count(sid) as total FROM(
//                    SELECT fileid as sid, memberid as smemberid, filetitle as stitle, filetype as stype FROM membersfile
//                    UNION
//                    SELECT directoryid as sid, memberid as smemberid, directorytitle as stitle, 'folder' as stype FROM membersdirectory
//                    )
//                    AS searchtable WHERE smemberid = '".$memberid."' AND stitle LIKE '%".$keyword."%' OR smemberid = '".$memberid."' AND stype LIKE '%".$keyword."%'");
//
//            }
//
//        }
//
//        $data = array('membersfileresults'=> $membersfileresults, 'membersfileresultscount' => $membersfilecount[0]['total'], 'page' => $page);
//        return $data;
//
//    } //end of memberfilelist function
//
//
//    public function memberdetelefolder(){
//        $request = new Request();
//        $transactionManager = new TxManager();
//        $transaction = $transactionManager->get();
//
//        if($request->isPost()){
//
//            $folderid   = $request->getPost('folderid');
//            $memberid   = $request->getPost('memberid');
//
//            try {
//
//                $deletefolder = Membersdirectory::findFirst("directoryid = '".$folderid."' AND memberid = '". $memberid ."'");
//                $deletefolder->setTransaction($transaction);
//                if($deletefolder){
//                    if(!$deletefolder->delete()){
//                        $transaction->rollback();
//                    }
//                }
//
//                foreach (Membersdirectory::find("directorypath like '%".$deletefolder->contentpath."%' AND memberid = '". $memberid ."'") as $deletefoldercontent) {
//                    $deletefoldercontent->setTransaction($transaction);
//                    if ($deletefoldercontent->delete() == false) {
//                        $transaction->rollback();
//                    }
//                }
//
//
//                foreach (Membersfile::find("filepath like '%".$deletefolder->contentpath."%' AND memberid = '". $memberid ."'") as $deletefilecontent) {
//                    $deletefilecontent->setTransaction($transaction);
//                    if ($deletefilecontent->delete() == false) {
//                        $transaction->rollback();
//                    }
//                }
//
//
//                $transaction->commit();
//                $data = array('success' => 'folder successfully deleted!', 'statuscode' => 200 );
//
//            }
//            catch (TxFailed $e) {
//                $data = array('error' => 'Something went wrong please try again later! Folder not deleted.', 'statuscode' => 400 );
//            }
//
//            return $data;
//
//        }
//
//    } //end of memberdetelefolder function
//
//
//    public function editfolder(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $folderid   = $request->getPost('folderid');
//            $foldertitle   = $request->getPost('foldertitle');
//            $memberid   = $request->getPost('memberid');
//
//            $updatefolder = Membersdirectory::findFirst("directoryid = '".$folderid."' AND memberid = '". $memberid ."'");
//
//            if($updatefolder){
//                $updatefolder->directorytitle = $foldertitle;
//                if($updatefolder->save()){
//                    $data = array('success' => 'folder successfully deleted!', 'statuscode' => 200 );
//                }
//                else{
//                    $data = array('error' => 'Something went wrong please try again later! Folder not updated.', 'statuscode' => 400 );
//                }
//            }
//
//            return $data;
//
//        }
//    }
//
//
//    public function memberdownloadfile(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid   = $request->getPost('memberid');
//            $filename   = $request->getPost('filename');
//
//            $key = 'uploads/memberfiles/'.$memberid.'/'.$filename;
//            $presignedurl = AC::s3PreSignUrl($key, $filename, true);
//            $membersfileresults['spresignurl'] = $presignedurl;
//
//            return $presignedurl;
//        }
//
//    }
//
//    public function saveroletemplate(){
//
//        $request = new Request();
//        $transactionManager = new TxManager();
//        $transaction = $transactionManager->get();
//        $guid = new Guid();
//
//        if($request->isPost()){
//
//            $identifier = $guid->GUID();
//            $name       = $request->getPost('name');
//            $roles      = $request->getPost('roles');
//
//            $checkrolename = Roletemplate::findFirst("name = '".$name."'");
//
//            if($checkrolename){
//                $data = array('exist' => 'Role template name is already exist!', 'statuscode' => 409 );
//            }
//            else{
//
//                try {
//
//                    foreach ($roles as $role) {
//
//                        $saveroletemplate = new Roletemplate();
//                        $saveroletemplate->setTransaction($transaction);
//
//                        $saveroletemplate->identifier = $identifier;
//                        $saveroletemplate->name = $name;
//                        $saveroletemplate->role = $role;
//
//                        if(!$saveroletemplate->save()){
//                            $transaction->rollback();
//                        }
//
//                    }
//
//
//                    $transaction->commit();
//                    $data = array('success' => 'Role template successfully saved!', 'statuscode' => 200 );
//
//                }
//                catch (TxFailed $e) {
//                    $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//                }
//
//             }
//        }
//
//        return $data;
//
//    }
//
//    public function getroletemplate(){
//        $roletemplate = CB::customQuery("SELECT identifier, name FROM roletemplate GROUP by name");
//        if($roletemplate){
//            return $roletemplate;
//        }
//    }
//
//    public function loadroletemplatebyid(){
//        $request = new Request();
//        if($request->isPost()){
//
//            $identifier = $request->getPost('identifier');
//
//            $roletemplate = CB::customQuery("SELECT name, role FROM roletemplate WHERE identifier = '".$identifier."'");
//
//            if($roletemplate){
//                return $roletemplate;
//            }
//        }
//
//    }
//
//    public function roletemplatelist(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $keyword   = $request->getPost('keyword');
//            $page      = $request->getPost('page');
//
//            $offset = ($page * 10) - 10;
//
//
//            if ($keyword == 'null' || $keyword == 'undefined' || $keyword == '') {
//
//                $roletemplateresults = CB::customQuery("SELECT identifier, name FROM roletemplate GROUP BY name LIMIT " . $offset . ",10");
//
//                $roletemplatecount = CB::customQuery("SELECT name as total FROM roletemplate GROUP BY name");
//
//            }
//            else{
//
//                $roletemplateresults = CB::customQuery();
//
//                $roletemplatecount = CB::customQuery();
//
//            }
//
//        }
//
//        $data = array('roletemplateresults'=> $roletemplateresults, 'roletemplatecount' => count($roletemplatecount), 'page' => $page);
//        return $data;
//
//    } //end of roletemplatelist function
//
//    public function deleteroletemplate(){
//        $request = new Request();
//        if($request->isPost()){
//
//            $identifier = $request->getPost('identifier');
//
//            $deleteroletemplate = Roletemplate::find("identifier = '".$identifier."'");
//
//            if($deleteroletemplate->delete()){
//                $data = array('success' => 'Role template successfully deleted!', 'statuscode' => 200 );
//            }
//            else{
//                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//            }
//        }
//
//        return $data;
//
//    }
//
//    public function editroletemplate(){
//
//        $request = new Request();
//        $transactionManager = new TxManager();
//        $transaction = $transactionManager->get();
//        $guid = new Guid();
//
//        if($request->isPost()){
//
//            $identifier = $request->getPost('identifier');
//            $name       = $request->getPost('name');
//            $roles      = $request->getPost('roles');
//
//            try {
//
//                $deleteroles = Roletemplate::find("identifier = '".$identifier."'");
//                if($deletememberrole){
//                    $deletememberrole->setTransaction($transaction);
//                }
//
//                if(!$deleteroles->delete()){
//                    $transaction->rollback();
//                }
//
//                foreach ($roles as $role) {
//
//                    $saveroletemplate = new Roletemplate();
//                    $saveroletemplate->setTransaction($transaction);
//
//                    $saveroletemplate->identifier = $identifier;
//                    $saveroletemplate->name = $name;
//                    $saveroletemplate->role = $role;
//
//                    if(!$saveroletemplate->save()){
//                        $transaction->rollback();
//                    }
//
//                }
//
//
//                $transaction->commit();
//                $data = array('success' => 'Role template successfully updated!', 'statuscode' => 200 );
//
//            }
//            catch (TxFailed $e) {
//                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//            }
//
//        }
//
//        return $data;
//
//    }
//
//    public function updatepasswordfirstlogin(){
//        $request = new Request();
//        $transactionManager = new TxManager();
//        $transaction = $transactionManager->get();
//
//        if($request->isPost()){
//
//            $memberid = $request->getPost('memberid');
//            $password = $request->getPost('password');
//            $skip = $request->getPost('skip');
//
//            try {
//
//                if($skip == 'false'){
//
//                    $authenticatemember = Members::findFirst("memberid='".$memberid."'");
//                    $authenticatemember->setTransaction($transaction);
//                    $loginstatus = $authenticatemember->getlogininfo();
//
//                    if($authenticatemember && $loginstatus->status == 'first'){
//
//                        $authenticatemember->password = sha1($password);
//                        if(!$authenticatemember->save()){
//                            $transaction->rollback();
//                        }
//
//                    }
//                    else{
//                        $transaction->rollback();
//                    }
//                }
//
//                $updateloginstatus = Logininfo::findFirst("memberid='".$memberid."'");
//                $updateloginstatus->setTransaction($transaction);
//                if($updateloginstatus){
//                    $updateloginstatus->status = 'security';
//                    if(!$updateloginstatus->save()){
//                        $transaction->rollback();
//                    }
//                }
//                else{
//                    $transaction->rollback();
//                }
//
//
//                $transaction->commit();
//                $data = array('success' => 'Your password is successfully updated!', 'statuscode' => 200 );
//
//            }
//            catch (TxFailed $e) {
//                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//            }
//
//
//
//        }
//        return $data;
//    }
//
//    public function getMemberList(){
//        $data = CB::customQuery("SELECT * FROM members");
//        $data = (count($data)!=0 ? array('success' => 'Fetching members record','data' => $data, 'statuscode' => 200 ) : array('error' => 'Something went wrong please unable to fetch mamber record try again later!', 'data'=>$data, 'statuscode' => 400 ));
//        return $data;
//    }
//
//    public function loadprofile(){
//
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid = $request->getPost('memberid');
//
//            $profile = Members::findFirst(array(
//                "conditions" => "memberid = '".$memberid."'",
//                "columns" => "memberid,firstname, lastname, suffix, birthdate, gender, ssn, address1, address2, city, state, zip, phone, mobile, picture"
//                ));
//
//            if($profile){
//                return $profile;
//            }
//            else{
//                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 404 );
//                return $data;
//            }
//        }
//
//
//    }
//
//    public function updateprofile(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid       = $request->getPost('memberid');
//            $password       = $request->getPost('password');
//            $firstname      = $request->getPost('firstname');
//            $lastname       = $request->getPost('lastname');
//            $suffix         = $request->getPost('suffix');
//            $birthdate      = $request->getPost('birthdate');
//            $gender         = $request->getPost('gender');
//            $ssn            = $request->getPost('ssn');
//            $address1       = $request->getPost('address1');
//            $address2       = $request->getPost('address2');
//            $city           = $request->getPost('city');
//            $state          = $request->getPost('state');
//            $zip            = $request->getPost('zip');
//            $phone          = $request->getPost('phone');
//            $mobile         = $request->getPost('mobile');
//
//            $updateprofile = Members::findFirst("memberid = '".$memberid."' AND password = '".sha1($password)."'");
//
//            if($updateprofile){
//
//                $updateprofile->firstname = $firstname;
//                $updateprofile->lastname = $lastname;
//                $updateprofile->suffix = $suffix;
//                $updateprofile->gender = $gender;
//                $updateprofile->ssn = $ssn;
//                $updateprofile->address1 = $address1;
//                $updateprofile->address2 = $address2;
//                $updateprofile->city = $city;
//                $updateprofile->state = $state;
//                $updateprofile->zip = $zip;
//                $updateprofile->phone = $phone;
//                $updateprofile->mobile = $mobile;
//
//                if($updateprofile->save()){
//                    $data = array('success' => 'Your profile is successfully updated!', 'statuscode' => 200 );
//                }
//                else{
//                    $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//                }
//
//            }
//            else{
//                $data = array('passworderror' => 'Something went wrong please try again later!', 'statuscode' => 401 );
//            }
//
//            return $data;
//
//        }
//    }
//
//    public function changepassword(){
//        $request = new Request();
//
//        if($request->isPost()){
//
//            $memberid      = $request->getPost('memberid');
//            $curpassword   = $request->getPost('curpassword');
//            $password      = $request->getPost('password');
//
//
//            $updateprofile = Members::findFirst("memberid = '".$memberid."' AND password = '".sha1($curpassword)."'");
//
//            if($updateprofile){
//
//                $updateprofile->password = sha1($password);
//
//                if($updateprofile->save()){
//                    $data = array('success' => 'password successfully updated!', 'statuscode' => 200 );
//                }
//                else{
//                    $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//                }
//
//            }
//            else{
//                $data = array('passworderror' => 'Something went wrong please try again later!', 'statuscode' => 401 );
//            }
//
//            return $data;
//
//        }
//    }
//
//    public function addSecurityQuestion(){
//        $request = new Request();
//        $transactionManager = new TxManager();
//        $transaction = $transactionManager->get();
//
//        if($request->isPost()){
//
//            $memberid  = $request->getPost('memberid');
//            $question1  = $request->getPost('sc1');
//            $answer1   = $request->getPost('sca1');
//            $question2  = $request->getPost('sc2');
//            $answer2   = $request->getPost('sca2');
//
//            $one = ['question' => $question1, 'answer' => $answer1];
//            $two = ['question' => $question2, 'answer' => $answer2];
//
//            $securityquestions = [];
//
//            array_push($securityquestions, $one);
//            array_push($securityquestions, $two);
//
//
//
//            try {
//
//                $deletequestions = Membersecurityquestions::find("memberid = '".$memberid."'");
//                // $deletequestions->setTransaction($transaction);
//
//                if($deletequestions){
//                    if(!$deletequestions->delete()){
//                        $transaction->rollback();
//                    }
//                }
//
//
//                foreach ($securityquestions as $list) {
//                    $savequestion = new Membersecurityquestions();
//                    $savequestion->memberid = $memberid;
//                    $savequestion->question = $list['question'];
//                    $savequestion->answer = $list['answer'];
//
//                    if(!$savequestion->save()){
//                        $errors = CB::geterrormessage($savequestion);
//                        $transaction->rollback();
//                    }
//
//                    // $datadata[] = $securityquestions;
//                }
//
//                $updateloginstatus = Logininfo::findFirst("memberid='".$memberid."'");
//                $updateloginstatus->setTransaction($transaction);
//                if($updateloginstatus){
//                    $updateloginstatus->status = 'active';
//                    if(!$updateloginstatus->save()){
//                        $transaction->rollback();
//                    }
//                }
//                else{
//                    $transaction->rollback();
//                }
//
//                $transaction->commit();
//                $data = array('success' => 'Your Security question is successfully saved!', 'statuscode' => 200 );
//
//
//            }
//            catch (TxFailed $e) {
//                $data = array('error' => 'Something went wrong please try again later!', 'statuscode' => 400 );
//            }
//
//            return $data;
//
//        }
//
//    }
//
//     public function loginstatus($memberid){
//
//        $checkmember = Members::findFirst("memberid='".$memberid."'");
//
//        if($checkmember){
//
//            $loginstatus = $checkmember->getlogininfo();
//
//            $data = array('success' => $loginstatus->status, 'statuscode' => 200 );
//        }
//
//        return $data;
//
//    } //end of checktoken fucntion
//
//    public function getsecurityquestion($memberid){
//        $getquestion = Membersecurityquestions::find("memberid = '".$memberid."'");
//        $data = [];
//        if($getquestion){
//            foreach ($getquestion as $getquestion) {
//                if(intval($getquestion->question) <= 10){
//                    $questionnum->question1 = $getquestion;
//                }
//                else{
//                    $questionnum->question2 = $getquestion;
//                }
//            }
//        }
//
//        return $questionnum;
//    }
//
//    public function getRoleitems(){
//
//        $rbm = [];
//        $rdl = [];
//        $rsr = [];
//        $rjf = [];
//        $rum = [];
//
//        $roleitem = Roleitems::find();
//
//        if($roleitem){
//            foreach ($roleitem as $list) {
//                if($list->roleGroup == 'rbm'){
//                    $rbmitem = ['id' => $list->roleCode, 'text' => $list->roleName];
//                    array_push($rbm, $rbmitem);
//                }
//                else if($list->roleGroup == 'rdl'){
//                    $rdlitem = ['id' => $list->roleCode, 'text' => $list->roleName];
//                    array_push($rdl, $rdlitem);
//                }
//                else if($list->roleGroup == 'rsr'){
//                    $rsritem = ['id' => $list->roleCode, 'text' => $list->roleName];
//                    array_push($rsr, $rsritem);
//                }
//                else if($list->roleGroup == 'rjf'){
//                    $rjfitem = ['id' => $list->roleCode, 'text' => $list->roleName];
//                    array_push($rjf, $rjfitem);
//                }
//                else if($list->roleGroup == 'rum'){
//                    $rumitem = ['id' => $list->roleCode, 'text' => $list->roleName];
//                    array_push($rum, $rumitem);
//                }
//            }
//        }
//        return array('rbm' => $rbm, 'rdl' => $rdl, 'rsr' => $rsr, 'rjf' => $rjf, 'rum' => $rum);
//    }
//
//    public function getRoleitemsCb(){
//        return array('roleitems' => self::getRoleitems());
//    }

}
