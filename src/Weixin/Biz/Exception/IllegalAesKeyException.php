<?php namespace Weixin\Biz\Exception;

use Exception;

class IllegalAesKeyException extends Exception {

    public __construct()
    {
        parent::construct('AES KEY非法', -40004);
    }

}