<?php 

namespace Weixin\Biz\Exception;

use Exception;

class Base64DecodeErrorException extends Exception 
{

    public function __construct()
    {
        parent::__construct('Base64 解密失败', -40010);
    }

}