<?php

namespace LaravelFangxu;

class Tool
{
    /**
     * 返回 Json 响应内容
     *
     * @param  array $data 详细结果
     * @param  string $msg 返回说明
     * @param  integer $code 状态码
     * @return object          Json 响应
     */
    public static function api($data = [], $msg = "ok", $code = 200)
    {
        return response()->json([
            "code" => (int)$code,
            "msg" => (string)$msg,
            "data" => $data,
        ]);
    }

    /**
     * 获取客户端真实IP地址
     *
     * @return string IP地址
     */
    public static function getClientIp()
    {
        $xForwardFor = request()->header("x-forwarded-for");

        if ($xForwardFor && $ips = explode(",", $xForwardFor)) {
            $ip = $ips[0];
        } else {
            $ip = null;
        }

        return $ip ?: request()->header("x-real-ip") ?: request()->getClientIp();
    }

    /**
     * OpenSSL 加密字符串
     * @param  string $v 需要加密的字符串
     * @param  string $aes 加密密钥
     * @param  string $method 加密方法
     * @return string         加密后的字符串
     */
    public static function passwordEncode($v, $aes = "1234567890123456", $method = "AES-128-ECB")
    {
        return base64_encode(openssl_encrypt($v, $method, substr($aes, strlen($aes) - 16)));
    }

    /**
     * OpenSSL 解密字符串
     * @param  string $v 加密后的字符串
     * @param  string $aes 加密密钥
     * @param  string $method 加密方法
     * @return string         解密后的字符串
     */
    public static function passwordDecode($v, $aes = "1234567890123456", $method = "AES-128-ECB")
    {
        return openssl_decrypt(base64_decode($v), $method, substr($aes, strlen($aes) - 16));
    }
}