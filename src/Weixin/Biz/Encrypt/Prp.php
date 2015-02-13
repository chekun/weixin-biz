<?php namespace Weixin\Biz\Encrypt;

use Exception;
use Weixin\Biz\Exception\AesEncryptErrorException;
use Weixin\Biz\Exception\AesDecryptErrorException;
use Weixin\Biz\Exception\IllegalBufferException;
use Weixin\Biz\Exception\InvalidCorpIdException;

class Prp {

    protected $key = null;

    public function __construct($key)
    {
        $this->key = base64_decode($key.'=');
    }

    public function encode($text, $corpId)
    {
        try {
            //获得16位随机字符串，填充到明文之前
            $random = $this->getRandomString();
            $text = $random.pack("N", strlen($text)).$text.$corpid;
            //网络字节序
            $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            //使用自定义的填充方式对明文进行补位填充
            $text = Pkcs7::encode($text);
            mcrypt_generic_init($module, $this->key, $iv);
            //加密
            $encrypted = mcrypt_generic($module, $text);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
            return base64_encode($encrypted);
        } catch (Exception $e) {
            throw new AesEncryptErrorException();
        }
    }

    public function decode($encrypted, $corpId)
    {
        try {
            //使用BASE64对需要解密的字符串进行解码
            $ciphertext = base64_decode($encrypted);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            mcrypt_generic_init($module, $this->key, $iv);

            //解密
            $decrypted = mdecrypt_generic($module, $ciphertext);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            throw new AesDecryptErrorException();
        }

        try {
            //去除补位字符
            $result = Pkcs7::decode($decrypted);
            //去除16位随机字符串,网络字节序和AppId
            if (strlen($result) < 16)
                return "";
            $content = substr($result, 16, strlen($result));
            $lenList = unpack("N", substr($content, 0, 4));
            $xmlLen = $lenList[1];
            $xmlContent = substr($content, 4, $xmlLen);
            $fromCorpId = substr($content, $xmlLen + 4);
        } catch (Exception $e) {
            return new IllegalBufferException();
        }

        if ($fromCorpId != $corpId)
            throw new InvalidCorpIdException();

        return $xmlContent;
    }

    protected function getRandomString()
    {
        $str = "";
        $pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $poolLength = strlen($pool) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $pool[mt_rand(0, $poolLength)];
        }
        return $str;
    }

}