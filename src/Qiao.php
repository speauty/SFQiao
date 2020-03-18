<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Qiao.php
 * Created: 2020/3/18 09:30:08
 */

namespace SFQiao;
use GuzzleHttp\Client;


class Qiao
{
    private $customerCode = '';
    private $checkWord = '';
    private $requestUrl = 'http://bsp-oisp.sf-express.com/bsp-oisp/sfexpressService';
    private $serviceName = '';
    private $sourceData = null;
    private $xmlStr = '';
    private $result = null;
    private $initRequest = '';
    private $initResponse = '';
    private $cusTid = '';

    private function exception(string $msg):void
    {
        throw new \Exception($msg);
    }

    private function setConf(array $conf)
    {
        $this->customerCode = $conf['customer_code']??'';
        $this->checkWord = $conf['check_word']??'';
        $this->cusTid = $conf['cus_tid']??'';
        if (isset($conf['request_url']) && $conf['request_url']) $this->requestUrl = $conf['request_url'];
    }

    private function verifyConf()
    {
        $checkList = [
            !$this->customerCode => 'the conf named customer code is empty',
            !$this->checkWord => 'the conf named check word is empty',
            !$this->requestUrl => 'the conf named request url is empty',
            !$this->serviceName => 'the conf named service name is empty',
            !$this->sourceData => 'the data is empty',
        ];
        foreach ($checkList as $k => $v) {
            if ($k) $this->exception($v);
        }
    }

    private function createXmlRecursion($data):string
    {
        $xml = '';
        foreach ($data as $key => $val)
        {
            $xmlScope = $key=='body'?'':"<{$key}%s>";
            if (!is_array($val)) {
                return "<{$key}>{$val}</{$key}>";
            }
            if (is_string($key)) {
                $attrStr = '';
                if (isset($val['attributes']) && $val['attributes']) {
                    if (is_array(current($val['attributes']))) {
                        $xml = '';
                        foreach ($val['attributes'] as $v) {
                            $xmlScope = "<{$key}%s></{$key}>";
                            $attrStr = '';
                            foreach ($v as $ak => $av) {
                                $attrStr .= " $ak=\"{$av}\"";
                            }
                            $xmlScope = sprintf($xmlScope, $attrStr);
                            $xml .= $xmlScope;
                        }
                        return $xml;
                    } else {
                        foreach ($val['attributes'] as $ak => $av) {
                            $attrStr .= " $ak=\"{$av}\"";
                        }
                    }
                }
                $xmlScope = sprintf($xmlScope, $attrStr);
            }
            if (isset($val['body']) && $val['body']) {
                foreach ($val['body'] as $bk => $bv) {
                    $xmlScope .= $this->createXmlRecursion([$bk => $bv]);
                }
            }
            $xmlScope .= $key=='body'?'':"</{$key}>";
            $xml .= $xmlScope;
        }
        return $xml;
    }

    private function result(\GuzzleHttp\Psr7\Response $response):?array
    {
        $result = [
            'state' => false,
            'msg' => '',
            'data' => null
        ];
        if ($response->getStatusCode() != 200) {
            $result['msg'] = $response->getReasonPhrase();
            return $result;
        }
        $this->initResponse = $response->getBody()->getContents();
        $bodyContent = $this->convertXml2Arr($this->initResponse);
        if (!$bodyContent) {
            $result['msg'] = '数据解析异常';
            $result['data'] = $response->getBody()->getContents();
            return $result;
        }
        if ($bodyContent['Head'] == 'ERR') {
            $result['msg'] = is_array($bodyContent['ERROR'])?json_encode($bodyContent['ERROR'], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE):$bodyContent['ERROR'];
            return $result;
        } else {
            $result['state'] = true;
            $result['data'] = $bodyContent['Body']??null;
        }
        return $result;
    }

    private function getVerifyCode():string
    {
        if (!$this->xmlStr) $this->getXmlStr();
        return base64_encode(md5($this->xmlStr.$this->checkWord, true));
    }

    private function convertXml2Arr($xmlStr)
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    public function getXmlStr():void
    {
        $this->verifyConf();
        $xmlHeader = '<Request service="'.$this->serviceName.'" lang="zh-CN"><Head>'.$this->customerCode.'</Head><Body>%s</Body></Request>';
        $this->xmlStr = sprintf($xmlHeader, $this->createXmlRecursion($this->sourceData));
    }

    public function __construct(array $conf)
    {
        $this->setConf($conf);
    }

    public function setServiceName(string $serviceName):self
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    public function setData(array $data):self
    {
        $this->sourceData = $data;
        return $this;
    }

    public function request()
    {
        if (!$this->xmlStr) $this->getXmlStr();

        $postData = [
            'xml' => $this->xmlStr,
            'verifyCode' => $this->getVerifyCode()
        ];
        $client = new Client();
        $result = $client->request('POST', $this->requestUrl, [
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8'
            ],
            'form_params' => $postData
        ]);
        $this->initRequest = http_build_query($postData);
        $this->result = $this->result($result);
    }

    public function getResult(bool $flagOnlyResult = false):array
    {
        if ($flagOnlyResult) return $this->result;
        return [
            'result' => $this->result,
            'init_request' => $this->initRequest,
            'init_response' => $this->initResponse,
        ];
    }

    // xml字符串解析
    public function quickParseXml(string $xml):?array
    {
        return $this->convertXml2Arr($xml)?:null;
    }

    // 路由查询
    public function quickRouteRequest(string $mailNo, ?array $extData = null, string $serviceName = 'RouteService'):?array
    {
        if (!$mailNo) $this->exception('the mailNo is empty');
        $data = [
            'RouteRequest' => [
                'attributes' => [
                    'tracking_type' => $extData['tracking_type']??'1',
                    'method_type' => $extData['tracking_type']??'1',
                    'tracking_number' => $mailNo,
                    'check_phoneNo' => $extData['check_phoneNo']??''
                ],
                'body' => null
            ]
        ];
        $this->setServiceName($serviceName)->setData($data)->request();
        $result = $this->getResult(true);
        if ($result['state']) {
            $routes = $result['data']['RouteResponse']['Route'];
            $routes = array_column($routes, '@attributes');
            return ['state' => true, 'msg' => '', 'data' => $routes];
        } else {
            return ['state' => false, 'msg' => $result['msg']];
        }
        return null;
    }

    // 订单结果查询
    public function quickOrderSearch(string $orderId, ?array $extData = null, string $serviceName = 'OrderSearchService'):?array
    {
        if (!$orderId) $this->exception('the orderId is empty');
        $data = [
            'OrderSearch' => [
                'attributes' => [
                    'orderid' => $orderId,
                    'search_type' => $extData['search_type']??'1'
                ],
                'body' => null
            ]
        ];
        $this->setServiceName($serviceName)->setData($data)->request();
        $result = $this->getResult(true);
        if ($result['state']) {
            return ['state' => true, 'msg' => '', 'data' => $result['data']['OrderResponse']['@attributes']];
        } else {
            return ['state' => false, 'msg' => $result['msg']];
        }
    }

    // 订单筛选
    public function quickOrderFilterService(string $address, ?array $extData = null, string $serviceName = 'OrderFilterService'):?array
    {
        if (!$address) $this->exception('the address is empty');
        $data = [
            'OrderFilter' => [
                'attributes' => [
                    'filter_type' => $extData['filter_type']??'1',
                    'orderid' => $extData['orderid']??"",
                    'd_address' => $address
                ],
                'body' => null
            ]
        ];
        if (isset($extData['OrderFilterOption']) && $extData['OrderFilterOption']) {
            $data['OrderFilter']['body']['OrderFilterOption'] = [
                'attributes' => $extData['OrderFilterOption'],
                'body' => null
            ];
        }
        $this->setServiceName($serviceName)->setData($data)->request();
        $result = $this->getResult(true);
        if ($result['state']) {
            $filterResult = $result['data']['OrderFilterResponse']['@attributes']['filter_result'];
            if ($filterResult == 1) {
                return ['state' => false, 'msg' => '等待人工确认'];
            } else if ($filterResult == 2) {
                return ['state' => true, 'msg' => '可收派', 'data' => [
                    'originCode' => $result['data']['OrderFilterResponse']['@attributes']['origincode'],
                    'destCode' => $result['data']['OrderFilterResponse']['@attributes']['destcode'],
                ]];
            } else {
                $remark = $result['data']['OrderFilterResponse']['@attributes']['remark'];
                $remarkMap = [
                    1 => '收方超范围',
                    2 => '派方超范围',
                    3 => '其它原因'
                ];
                return ['state' => false, 'msg' => '不可以收派', 'data' => [
                    'msg_more' => $remarkMap[$remark]??'未知原因'
                ]];
            }
        } else {
            return ['state' => false, 'msg' => $result['msg']];
        }
    }

    // 中国大陆件
    public function quickOrderMainland(array $mustData, ?array $extData = null, string $serviceName = 'OrderService'):?array
    {
        $mustDataIdx = [
            'orderid', 'j_contact', 'j_tel', 'j_address',
            'd_contact', 'd_tel', 'd_address', 'products'
        ];
        foreach ($mustDataIdx as $v) {
            if (!isset($mustData[$v]) || !$mustData[$v]) {
                $this->exception("the {$v} is empty");
            }
        }
        $data = [
            'Order' => [
                'attributes' => [
                    'orderid' => $mustData['orderid'],
                    'mailno' => $extData['mailno']??"",
                    'j_company' => $extData['j_company']??'顺丰速运',
                    'j_contact' => $mustData['j_contact'],
                    'j_tel' => $mustData['j_tel'],
                    'j_address' => $mustData['j_address'],
                    'd_contact' => $mustData['d_contact'],
                    'd_tel' => $mustData['d_tel'],
                    'd_company' => $extData['d_company']??'顺丰速运',
                    'd_address' => $mustData['d_address'],
                    'custid' => $this->cusTid,
                    'pay_method' => $extData['pay_method']??'1',
                    'express_type' => $extData['express_type']??'1',
                    'remark' => $extData['remark']??"",
                ],
                'body' => [
                    'Cargo' => [
                        'attributes' => []
                    ]
                ]
            ]
        ];
        foreach ($mustData['products'] as $v) {
            $data['Order']['body']['Cargo']['attributes'][] = [
                'name' => $v['name']??'',
                'count' => $v['count']??''
            ];
        }
        $this->setServiceName($serviceName)->setData($data)->request();
        $result = $this->getResult(true);
        if ($result['state']) {
            $data = $result['data']['OrderResponse']['@attributes']+['rls_info' => $result['data']['OrderResponse']['rls_info']['@attributes']+['rls_detail' =>$result['data']['OrderResponse']['rls_info']['rls_detail']['@attributes']]];
            return ['state' => true, 'msg' => '', 'data' => $data];
        } else {
            return ['state' => false,'msg' => $result['msg']];
        }
    }

    // 跨境件
    public function quickOrderCrossBorder(array $mustData, ?array $extData = null, string $serviceName = 'OrderService'):array
    {
        $this->exception('暂未开发');
        return [];
    }

    // 订单取消
    public function quickOrderCancel(string $orderId, string $serviceName = 'OrderConfirmService'):array
    {
        if (!$orderId) $this->exception('the orderId is empty');
        $data = [
            'OrderConfirm' => [
                'attributes' => [
                    'orderid' => $orderId,
                    'dealtype' => '2'
                ],
                'body' => null
            ]
        ];
        $this->setServiceName($serviceName)->setData($data)->request();
        $result = $this->getResult(true);
        if ($result['state']) {
            $resStatus = $result['data']['OrderConfirmResponse']['@attributes']['res_status'];
            if ($resStatus == 1) {
                return ['state' => false, 'msg' => '客户订单号与顺丰运单不匹配'];
            } else if ($resStatus == 2) {
                return ['state' => true, 'msg' => ''];
            } else {
                return ['state' => false, 'msg' => '未知错误'];
            }
        } else {
            return ['state' => false, 'msg' => $result['msg']];
        }
    }

}