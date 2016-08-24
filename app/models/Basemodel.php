<?php

namespace App\Models;

class Basemodel extends \Phalcon\Mvc\Model
{
    public $dateedited;
    public $datecreated;

    public function beforeCreate()
    {
        $this->datecreated = date('Y-m-d H:i:s');
        $this->dateedited = $this->createdAt;
    }

    public function beforeUpdate()
    {
        $this->dateedited = date('Y-m-d H:i:s');
    }
}
