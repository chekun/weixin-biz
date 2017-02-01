<?php 

namespace Weixin\Biz\Encrypt;

class Pkcs7 
{

    const BLOCK_SIZE = 32;

    public static function encode($text)
    {
        $textLength = strlen($text);
        $padLength = static::BLOCK_SIZE - ($textLength % static::BLOCK_SIZE);
        if ($padLength == 0) {
            $padLength = static::BLOCK_SIZE;
        }
        $padChr = chr($padLength);
        $temp = "";
        for ($index = 0; $index < $padLength; $index ++) {
            $temp .= $padChr;
        }
        return $text.$temp;
    }

    public static function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 or $pad > static::BLOCK_SIZE) {
            $pad = 0;
        }
        return substr($text, 0, strlen($text) - $pad);
    }

}