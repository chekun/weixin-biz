<?php 

namespace Weixin\Biz\Exception;

use Exception;

class IllegalAesKeyException extends Exception 
{

    public function __construct()
    {
        parent::__construct('AES KEY非法', -40004);
    }

}