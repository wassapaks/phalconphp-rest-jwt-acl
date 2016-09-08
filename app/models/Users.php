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

        $this->hasMany("memberid", "App\Models\Memberroles", "memberid", array('alias' => 'memberroles'));

    }
    public function getPayLoad(){
        $payload = array(
            "id"      => $this->memberid,
            "email"         => $this->email,
            "firstname"     => $this->firstname,
            "lastname"      => $this->lastname,
            "picture"       => $this->picture,
            "permission"    => $this->permission
        );
        return $payload;
    }
    public static function recordList($options)
    {
        // A raw SQL statement

        $sql = "SELECT " . (is_array($options['cols']) ? implode(',', $options['cols']) : '') . " FROM Members " . (isset($options['conditions']) ? " WHERE " . $options['conditions'] : '') . ' ' . (isset($options['after_statements']) ? $options['after_statements'] : '');

        // Base model

        $members = new Members();

        // Execute the query
        $query = $options['params'] == null ? $members->getReadConnection()->query($sql) : $members->getReadConnection()->query($sql, $options['params']);
        return new Resultset(null, $members, $query);
    }
    public static function userMemberroles(){
        // A raw SQL statement
        $sql = "SELECT members.memberid, memberroles.role, members.userLevel FROM memberroles RIGHT JOIN members ON members.memberid = memberroles.memberid";

        // Base model

        $members = new Members();

        // Execute the query
        $query = $members->getReadConnection()->query($sql);
        return new Resultset(null, $members, $query);
    }
}
