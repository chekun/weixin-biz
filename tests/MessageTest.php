<?php

use Weixin\Biz\Biz;

class MessageTest extends PHPUnit_Framework_TestCase 
{

    public function testPackMessage()
    {
        $aesKey = getenv('WECHAT_AGENT_AES');
        $token = getenv('WECHAT_AGENT_TOKEN');
        $corpId = getenv('WECHAT_CORP_ID');
        $agentId = getenv('WECHAT_AGENT_ID');

        $timestamp = 1485953748;
        $nonce = '5891dad42a4a1';

        $message = '<xml>
   <ToUserName><![CDATA['.$agentId.']]></ToUserName>
   <FromUserName><![CDATA[chekun]]></FromUserName>
   <CreateTime>'.$timestamp.'</CreateTime>
   <MsgType><![CDATA[text]]></MsgType>
   <Content><![CDATA[Hello,WeixinBiz.]]></Content>
</xml>';

        $biz = new Biz($token, $aesKey, $corpId);
        
        $encryptedMessage = $biz->packMessage($message, $timestamp, $nonce);

        $encryptedObject = $this->xml2object($encryptedMessage);

        $unpackedMessage = $biz->unpackMessage(
            $encryptedObject->MsgSignature, 
            $timestamp, 
            $nonce, 
            str_replace('</xml>', '<ToUserName><![CDATA[chekun]]></ToUserName></xml>', $encryptedMessage)
        );

        $unpackObject = $this->xml2object($unpackedMessage);

        $this->assertEquals($timestamp, $unpackObject->CreateTime);
        $this->assertEquals($unpackObject->Content, 'Hello,WeixinBiz.');
    }

    protected function xml2object($xmlContent)
    {
        $xml = @simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode((array) $xml));
    }

}
