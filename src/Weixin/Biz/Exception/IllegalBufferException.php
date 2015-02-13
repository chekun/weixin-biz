<?php namespace Weixin\Biz\Exception;

use Exception;

class IllegalBufferException extends Exception {

    public function __construct()
    {
        parent::__construct('解密的Buffer非法', -40008);
    }

}