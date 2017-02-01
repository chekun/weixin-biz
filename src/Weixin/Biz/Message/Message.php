<?php 

namespace Weixin\Biz\Message;

use Exception;
use DOMDocument;
use Weixin\Biz\Exception\XmlDecodeErrorException;

class Message 
{

    const ENCRYPT_TAG_NAME = 'Encrypt';

    const TO_USERNAME_TAG_NAME = 'ToUserName';

    public static function decode($xmlText)
    {
        try {
            $xml = new DOMDocument();
            $xml->loadXML($xmlText);
            $encrypt = $xml->getElementsByTagName(static::ENCRYPT_TAG_NAME)
                ->item(0)
                ->nodeValue;
            $toUsername = $xml->getElementsByTagName(static::TO_USERNAME_TAG_NAME)
                ->item(0)
                ->nodeValue;
            return [$encrypt, $toUsername];
        } catch (Exception $e) {
            throw new XmlDecodeErrorException();
        }
    }

    public static function encode($encrypt, $signature, $timestamp, $nonce)
    {
        $format = '<xml>
    <Encrypt><![CDATA[%s]]></Encrypt>
    <MsgSignature><![CDATA[%s]]></MsgSignature>
    <TimeStamp>%s</TimeStamp>
    <Nonce><![CDATA[%s]]></Nonce>
</xml>';
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }

}