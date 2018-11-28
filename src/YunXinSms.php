<?php

namespace DishCheng\YunXinSms;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Facade;

/**
 * Created by PhpStorm.
 * User: caicheng
 * Date: 2018-11-28
 * Time: 18:42
 */
class YunXinSms extends Facade
{
    /**
     * 网易云信验证码短信
     * @param $params
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function code_post($params)
    {
        $response = self::post('https://api.netease.im/sms/sendcode.action', $params);
        return $response;
    }


    /**
     * 网易云信通知类短信
     * @param $params
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function notice_post($params)
    {
        $response = self::post('https://api.netease.im/sms/sendtemplate.action', $params);
        return $response;
    }


    /**
     * 发送请求（返回数组）
     * @param $curl
     * @param $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function post($curl, $params)
    {
//        dd($params);
        $client = new Client();
        $nonce = mt_rand(100000, 999999);
        $time = time();
        try {
            $response = $client->request('post', $curl,
                ['headers' =>
                    [
                        'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8',
                        'AppKey' => config('yunxinsms.AppKey'),
                        'Nonce' => $nonce,
                        'CurTime' => $time,
                        'CheckSum' => self::getCheckSum($nonce, $time),
                    ],
                    'form_params' => $params,
                ]
            );
            //验证码
            //2**开头的状态码返回的信息
            //正确的状态
            //array(3) { ["code"]=> int(200) ["msg"]=> string(4) "4311" ["obj"]=> string(4) "1111" }
            //错误的状态
            //array(3) { ["code"]=> int(416) ["msg"]=> string(12) "mobile limit" ["obj"]=> string(24) "4182342||+86-138888888" }
            return json_decode((string)$response->getBody(), true);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            //for example
            //$exception->getMessage()
            //Client error: `POST https://api.netease.im/sms/sendcode.action` resulted in a `400 Bad Request` response:\n
            //<html><head><title>Apache Tomcat/7.0.52 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:w (truncated...)\n
            if ($exception->getCode() == 400) {
                return ['code' => $exception->getCode(), 'msg' => '参数错误'];
            }
            return ['code' => $exception->getCode(), 'msg' => $exception->getMessage()];
        }
    }

    /**
     * 计算并获取CheckSum
     * @param $nonce
     * @param $curTime
     * @return string
     */
    private static function getCheckSum($nonce, $curTime)
    {
        return sha1(config('yunxinsms.AppSecret') . $nonce . $curTime);
    }


}