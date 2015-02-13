<?php namespace Weixin\Biz\Exception;

use Exception;

class XmlEncodeErrorException extends Exception {

    public function __construct()
    {
        parent::__construct('XML生成失败', -40011);
    }

}