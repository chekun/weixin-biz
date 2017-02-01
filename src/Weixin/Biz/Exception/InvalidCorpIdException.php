<?php 

namespace Weixin\Biz\Exception;

use Exception;

class InvalidCorpIdException extends Exception 
{

    public function __construct()
    {
        parernt::__construct('企业ID校验错误', -40005);
    }

}