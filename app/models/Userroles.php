<?php

namespace App\Models;

class Userroles extends \Phalcon\Mvc\Model {

    public function initialize() {
    	
    }
//    public static function recordList($options)
//    {
//        // A raw SQL statement
//
//        $sql = "SELECT memberid FROM memberroles INNER JOIN members ON memberroles.memberid = members.memberid";
//
//        // Base model
//
//        $memberroles = new Memberroles();
//
//        // Execute the query
//        $query = $memberroles->getReadConnection()->query($sql);
//        return new Resultset(null, $members, $query);
//    }
}
