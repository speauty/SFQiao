<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OSS.php
 * Created: 2020-04-09 01:28:15
 */
declare(strict_types=1);

namespace SFQiao\Lib\data;


/**
 * Class Data_OSS 订单结果查询服务数据模型
 * @package SFQiao\Lib\data
 */
class Data_OSS extends Data
{
    /** @var string 客户订单号 */
    public $orderId = "";
    /**
     * @var string 查询类型
     * 1. 正向单查询, 传入的orderid为正向定单号
     * 2. 退货单查询, 传入的orderid为退货原始订单号
     */
    public $searchType = "1";
    /** @var string 键名 */
    public $serviceNameMapKey = 'OSS';

    public function getData():?array
    {
        return [
            'OrderSearch' => [
                'attributes' => [
                    'orderid' => $this->orderId,
                    'search_type' => $this->searchType
                ],
                'body' => null
            ]
        ];
    }
}