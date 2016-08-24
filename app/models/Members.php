<?php

namespace App\Models;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Members extends \Phalcon\Mvc\Model {

    public $memberid;
    public $firstname;
    public $lastname;
    public $permission;

    public function initialize() {

    	$this->setSource('members');
    	$this->hasOne('memberid', 'Models\Logininfo', 'memberid',array('alias' => 'logininfo'));

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
}
