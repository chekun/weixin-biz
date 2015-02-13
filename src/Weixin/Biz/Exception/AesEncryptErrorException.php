<?php namespace Weixin\Biz\Exception;

use Exception;

class AesEncryptErrorException extends Exception {

    public function __construct()
    {
        parent::__construct('AES 加密失败', -40006);
    }

}