<?php

namespace Models;

class Membersfile extends \Phalcon\Mvc\Model {

    public function initialize() {

    }

    public function samplequery(){

        $sample = CB::createBuilder()
        ->columns(array('Models\Membersdirectory.directoryid','Models\Membersfile.filepath'))
        ->from('Models\Membersdirectory')
        ->leftJoin('Models\Membersfile', 'Models\Membersdirectory.contentpath = Models\Membersfile.filepath')
        ->where('Models\Membersdirectory.directoryid = "8CE049B1-3D42-4FF5-A121-98AA3EEBECE7"')
        ->getQuery()
        ->execute();

        echo json_encode($sample->toArray());
    }

}
