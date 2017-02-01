<?php 

namespace Weixin\Biz\Exception;

use Exception;

class SignatureValidateErrorException extends Exception 
{

    public function __construct()
    {
        parent::__construct('签名验证错误', -40001);
    }

}