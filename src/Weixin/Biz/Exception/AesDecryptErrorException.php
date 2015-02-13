<?php namespace Weixin\Biz\Exception;

use Exception;

class AesDecryptErrorException extends Exception {

    public function __construct()
    {
        parent::__construct('AES 解密失败', -40007);
    }

}