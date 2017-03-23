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

         var_dump($rolesResources);
         die();

        $data = array(AclRoles::setAcl($rolesResources,$users) ? "Successfully created your roles!": "Something went wrong");

        return $data;

    }

    public function initializeAcl(){

        $users = Users::find();

         // $rolesResources = array($users->userid => array());
         $collections = $this->di->getShared('collections');

        $rec = new Users();


        $rolesResources = array();

        foreach($users as $m){
            foreach($collections as $col){
                // var_dump($col);
                // var_dump($col->getHandlers());
                $controller = str_replace('App\Controllers\\','',$col['handler']);
                foreach($col['collection'] as $colh) {
                    
                    if($m->employeetype=="OWNER"){
                        $rolesResources[$m->userid][$controller][] = $colh[2];
                    }else{


                     if(isset($colh[4])){
                        $sql = ["userid=?0 AND role=?1", "bind"=>[$m->userid, $colh[4]]];
                         if(is_array($colh[4])){
                            $bind = [];
                            $count = 1;
                            foreach ($colh[4] as $val) {
                                $bind[] = ' role=?' . $count;
                                $count++;
                            }

                            $data = array_merge([$m->userid], $colh[4]);
                            $sql = ["userid=?0 AND (".implode(' OR ', $bind).")", "bind"=> $data ];
                         }
                            $rec  = \App\Models\Userroles::findFirst($sql);
                            if($rec){
                                $rolesResources[$rec->userid][$controller][] = $colh[2];      
                            }
                     }

                    }
                }
            }            
        }

        $msg = array();

        foreach ($rolesResources as $key => $value) {
            $msg[$key] = AclRoles::setAcl([$key => $value],[$key],  $key."-ACL-RECORD") ? "Successfully created your roles!": "Unsuccessfull";
        }

        return $msg;
    }

}
