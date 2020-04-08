<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    SFQSdk.php
 * Created: 2020-04-09 01:18:53
 */
declare(strict_types=1);
namespace SFQiao;
use GuzzleHttp\Client;
use SFQiao\lib\data\Data_OSS;
use SFQiao\lib\Tool;
use SFQiao\lib\traits\TraitConf;
use SFQiao\lib\traits\TraitResult;


/**
 * Class Qiao
 * @package SFQiao
 */
class SFQSdk
{
    use TraitConf, TraitResult;

    public function __construct()
    {
        $this->zero();
    }

    private function zero():void
    {
        $this->initConf();
        $this->initResult();
    }

    private function request(?array $postData):void
    {
        $client = new Client();
        $result = $client->request('POST', $this->conf()->requestUri, [
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8'
            ],
            'form_params' => $postData
        ]);
        $this->result()->setInitRequest($postData);
        $this->result()->setResponse($result);
    }

    /**
     * 订单下单结果查询
     * @param Data_OSS $data 订单下单结果查询数据模型
     * @param bool $resultWithInitInfo 返回数据是否包含原始请求和响应数据
     * @return array|null
     * @throws lib\exception\Qexception
     */
    public function quickQueryOrderResult(Data_OSS $data, bool $resultWithInitInfo = false): ?array
    {
        $data->setConf($this->conf);
        $this->conf()->validate();
        $xmlStr = $data->getXmlStr();
        $verifyCode = Tool::getVerifyCode($xmlStr, $this->conf()->checkWord);
        $postData = ['xml' => $xmlStr, 'verifyCode' => $verifyCode];
        $this->request($postData);
        $result = $this->result()->getResult($resultWithInitInfo);
        if (
            isset($result['data']) && $result['data'] &&
            isset($result['data']['OrderResponse']) && $result['data']['OrderResponse'] &&
            isset($result['data']['OrderResponse']['@attributes']) && $result['data']['OrderResponse']['@attributes']
        ) {
            $result['data'] = $result['data']['OrderResponse']['@attributes'];
        }
        return $result;
    }
}