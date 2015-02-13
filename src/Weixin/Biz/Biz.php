<?php namespace Weixin\Biz;

use Weixin\Biz\Encrypt\Prp;
use Weixin\Biz\Hash\Hash;
use Weixin\Biz\Message\Message;
use Weixin\Biz\Exception\IllegalAesKeyException;
use Weixin\Biz\Exception\SignatureValidateErrorException;

class Biz {

    protected $token = null;

    protected $aesKey = null;

    protected $corpId = null;

    protected $prp = null;

    public function __construct($token, $aesKey, $corpId)
    {
        $this->token = $token;
        $this->aesKey = $aesKey;
        $this->corpId = $corpId;

        if (strlen($this->aesKey) != 43) {
            throw new IllegalAesKeyException();
        }

        $this->prp = new Prp($this->aesKey);
    }

    public function verifyUrl($signature, $timestamp, $nonce, $echoStr)
    {

        $shaSignature = Hash::sha1($this->token, $timestamp, $nonce, $echoStr);

        if ($signature != $shaSignature) {
            throw new SignatureValidateErrorException();
        }

        return $this->prp->decode($echoStr, $this->corpId);

    }

    public function packMessage($replyMessage, $timestamp, $nonce)
    {
        $encrypt = $this->prp->encode($replyMessage, $this->corpId);
        if (is_null($timestamp)) {
            $timestamp = time();
        }
        $shaSignature = Hash::sha1($this->token, $timestamp, $nonce, $encrypt);
        return Message::encode($encrypt, $signature, $timestamp, $nonce);
    }

    public function unpackMessage($signature, $timestamp, $nonce, $postData)
    {
        list($encrypt, $toUsername) = Message::decode($postData);

        if (is_null($timestamp)) {
            $timestamp = time();
        }

        $shaSignature = Hash::sha1($this->token, $timestamp, $nonce, $encrypt);

        if ($shaSignature != $signature) {
            throw new SignatureValidateErrorException();
        }

        return $this->prp->decode($encrypt, $this->corpId);
        
    }

}