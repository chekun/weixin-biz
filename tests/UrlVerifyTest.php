<?php

use Weixin\Biz\Biz;
use Weixin\Biz\Hash\Hash;
use Weixin\Biz\Encrypt\Prp;

class UrlVerifyTest extends PHPUnit_Framework_TestCase 
{

    public function testVerifyUrl()
    {
        $aesKey = getenv('WECHAT_AGENT_AES');
        $token = getenv('WECHAT_AGENT_TOKEN');
        $corpId = getenv('WECHAT_CORP_ID');
        //生成验证URL的参数
        $prp = new Prp($aesKey);
        $timestamp = time();
        $nonce = uniqid();
        $echoStr = 'Hello,WeixinBiz.';
        $encryptedEchoStr = $prp->encode($echoStr, $corpId);
        $signature = Hash::sha1(
            $token,
            $timestamp,
            $nonce,
            $encryptedEchoStr
        );
        $biz = new Biz($token, $aesKey, $corpId);
        $this->assertEquals(
            $biz->verifyUrl($signature, $timestamp, $nonce, $encryptedEchoStr),
            $echoStr
        );
    }

}
