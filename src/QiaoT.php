<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    QiaoT.php
 * Created: 2020-04-09 01:18:53
 */
declare(strict_types=1);
namespace SFQiao;
use GuzzleHttp\Client;
use SFQiao\Lib\Conf;
use SFQiao\Lib\data\Data_OSS;
use SFQiao\Lib\Tool;
use SFQiao\Lib\traits\TraitConf;


/**
 * Class QiaoT
 * @package SFQiao
 */
class QiaoT
{
    use TraitConf;

    public function __construct()
    {
        $this->zero();
    }

    private function zero():void
    {
        $this->initConf();
    }

    public function quickOrderSearch(Data_OSS $data): ?array
    {
        $data->setConf($this->conf);
        $this->conf()->validate();
        $xmlStr = $data->getXmlStr();
        $verifyCode = Tool::getVerifyCode($xmlStr, $this->conf()->checkWord);
        $client = new Client();
        $postData = [
            'xml' => $xmlStr,
            'verifyCode' => $verifyCode
        ];
        $result = $client->request('POST', $this->conf()->requestUri, [
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8'
            ],
            'form_params' => $postData
        ]);
        var_dump($result->getBody()->getContents());
        return null;
        /*$data->validate();
        $this->setServiceName($serviceName)->setData($data)->request();
        $result = $this->getResult(true);
        if ($result['state']) {
            return ['state' => true, 'msg' => '', 'data' => $result['data']['OrderResponse']['@attributes']];
        } else {
            return ['state' => false, 'msg' => $result['msg']];
        }*/
    }
}