<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderSearchService.php
 * Created: 2020-04-09 01:28:15
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;


/**
 * Class Data_OSS 订单结果查询服务数据模型
 * @package SFQiao\Lib\Data
 */
class Data_OrderSearchService extends Data
{
    /** @var string 服务映射键名 */
    protected $serviceNameMapKey = 'OrderSearchService';
    /** @var string 客户订单号 */
    public $orderId = "";
    /**
     * @var string 查询类型
     * 1. 正向单查询, 传入的orderid为正向定单号
     * 2. 退货单查询, 传入的orderid为退货原始订单号
     */
    public $searchType = "1";

    public function getData():?array
    {
        $result = $this->loadPublicParams($this);
        return $result;
    }
}