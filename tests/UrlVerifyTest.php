<?php

use Weixin\Biz\Biz;

class UrlVerifyTest extends PHPUnit_Framework_TestCase {

    public function testVerifyUrl()
    {
        $aesKey = "jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C";
        $token = "QDG6eK";
        $corpId = "wx5823bf96d3bd56c7";

        $signature = "5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3";
        $timestamp = "1409659589";
        $nonce = "263014780";
        $echoStr = "P9nAzCzyDtyTWESHep1vC5X9xho/qYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp+4RPcs8TgAE7OaBO+FZXvnaqQ==";

        $biz = new Biz($token, $aesKey, $corpId);
        $this->assertEquals($biz->verifyUrl($signature, $timestamp, $nonce, $echoStr), '1616140317555161061');
    }

}
