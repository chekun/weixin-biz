<?php 

namespace Weixin\Biz\Hash;

use Exception;
use Weixin\Biz\SignatureComputeErrorException;

class Hash 
{

    public static function sha1($token, $timestamp, $nonce, $encrypt)
    {
        try {
            $data = array($token, $timestamp, $nonce, $encrypt);
            sort($data, SORT_STRING);
            return sha1(implode($data));
        } catch (Exception $e) {
            return new SignatureComputeErrorException();
        }
    }

}