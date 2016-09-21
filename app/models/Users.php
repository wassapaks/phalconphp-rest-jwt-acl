<?php

namespace App\Models;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Users extends \Phalcon\Mvc\Model {

    public $memberid;
    public $firstname;
    public $lastname;
    public $permission;

    public function initialize() {

    	//$this->setSource('members');
    	//$this->hasOne('memberid', 'App\Models\Logininfo', 'memberid',array('alias' => 'logininfo'));

        //$this->hasMany("memberid", "App\Models\Userroles", "memberid", array('alias' => 'userroles'));

    }
    public function getPayLoad(){
        $payload = array(
            "id"      => $this->userid,
            "email"         => $this->email,
            "firstname"     => $this->firstname,
            "lastname"      => $this->lastname,
            "picture"       => $this->picture,
            "permission"    => $this->permission
        );
        return $payload;
    }
//    public static function recordList($options)
//    {
//        // A raw SQL statement
//
//        $sql = "SELECT " . (is_array($options['cols']) ? implode(',', $options['cols']) : '') . " FROM Members " . (isset($options['conditions']) ? " WHERE " . $options['conditions'] : '') . ' ' . (isset($options['after_statements']) ? $options['after_statements'] : '');
//
//        // Base model
//
//        $members = new Members();
//
//        // Execute the query
//        $query = $options['params'] == null ? $members->getReadConnection()->query($sql) : $members->getReadConnection()->query($sql, $options['params']);
//        return new Resultset(null, $members, $query);
//    }
    public function userAndRoles(){
        // A raw SQL statement
        $sql = "SELECT users.userid, userroles.role, users.userLevel FROM App\Models\Userroles as userroles RIGHT JOIN App\Models\Users as users ON users.userid = userroles.userid";

        // Execute the query
        $builder = $this->modelsManager->executeQuery($sql);

        return $builder;
    }
}
