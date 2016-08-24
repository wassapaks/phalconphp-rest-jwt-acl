<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 07/07/2016
 * Time: 4:53 PM
 */

namespace Services;


class ErrorMessages
{
    public function thrower($code, $message,$dev = '', $internalcode='',$more=''){
        throw new \Micro\Exceptions\HTTPExceptions(
            $message,
            406,
            array(
                'dev' => $dev,
                'internalCode' => $internalcode,
                'more' => $more
            )
        );
    }

    public function userExist($message,$other=null,$internalCode=null){
        $this->thrower(409,$message, 'Data requested should only be unique.',$internalCode, $other);
    }

    public function conditionFailed($message="Condition Failed.", $other=null,$internalCode = null){
        $this->thrower(412,$message, 'Data requested should only be unique.',$internalCode, $other);
    }

}
