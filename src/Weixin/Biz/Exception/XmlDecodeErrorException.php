<?php namespace Weixin\Biz\Exception;

use Exception;

class XmlDecodeErrorException extends Exception {

    public function __construct()
    {
        parent::__construct('XML解析失败', -40002);
    }

}