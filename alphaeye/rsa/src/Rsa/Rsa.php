<?php namespace AlphaEyeRsa\Rsa;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/6/28
 * Time: 上午11:48
 */
class Rsa
{
    protected $config;

    public function __construct()
    {
        $config = require (__DIR__. '/../../config/rsa.php');

        $this->config = $config;
    }

    protected function getPublicKey()
    {
        return openssl_pkey_get_public($this->config['public_key']);
    }

    protected function getPrivateKey()
    {
        return openssl_pkey_get_private($this->config['private_key']);
    }

    /**
     * 公钥加密
     * @param string $value 要加密的数据
     * @return string 加密后的字符串
     */
    public function publicKeyEncode($value)
    {
        $encrypted = null;
        openssl_public_encrypt($value, $encrypted, $this->getPublicKey());

        return base64_encode($encrypted);
    }

    /**
     * 用私钥解密公钥加密内容
     * @param string $value  要解密的数据
     * @return string 解密后的字符串
     */
    public function decodePublicKeyEncode($value)
    {
        $decrypted = '';
        openssl_private_decrypt(base64_decode($value), $decrypted, $this->getPrivateKey()); //私钥解密

        return $decrypted;
    }

    /**
     * 用私钥解密公钥加密内容
     * @param string $value  要解密的数据
     * @return string 解密后的字符串
     */
    public function privateKeyEncode($value)
    {
        $encrypted = null;
        openssl_private_encrypt($value, $encrypted, $this->getPrivateKey());

        return base64_encode($encrypted);
    }

    /**
     * 用公钥解密私钥加密内容
     * @param string $value 要解密的数据
     * @return string 解密后的字符串
     */
    public function decodePrivateKeyEncode($value)
    {
        $decrypted = null;
        openssl_public_decrypt(base64_decode($value), $decrypted, $this->getPublicKey());

        return $decrypted;
    }


}