<?php namespace Weixin\Biz\Exception;

use Exception;

class Base64EncodeErrorException extends Exception {

    public function __construct()
    {
        parent::__construct('Base64加密失败', -40009);
    }

}