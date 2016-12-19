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
                 if( isset($colh[2]) ){
                     $rolesResources[$own->userid][$controller][] = $colh[2];
                 }

                 foreach($rec->userAndRoles() as $r){

                     $currentRole = false;
                     if(isset($colh[4])){
                         if(is_array($colh[4])){
                             $currentRole = in_array($r->role , $colh[4]);
                         }else{
                             $currentRole = $colh[4] == $r->role ? true : false;
                         }
                     }

                     if($currentRole && $r->userid != $own->userid) {
                         if(!isset($rolesResources[$r->userid])){
                             $users[] = $r->userid;
                         }
                         $rolesResources[$r->userid][$controller][] = $colh[2];
                     }
                 }
             }
         }

        $data = array(AclRoles::setAcl($rolesResources,$users) ? "Successfully created your roles!": "Something went wrong");

        return $data;

    }

}
