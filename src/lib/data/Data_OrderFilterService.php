<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderFilterService.php
 * Created: 2020-04-09 22:17:39
 */
declare(strict_types=1);
namespace SFQiao\Lib\Data;


/**
 * Class Data_OrderFilterService
 * @package SFQiao\Lib\Data
 */
class Data_OrderFilterService extends Data
{
    /** @var string 服务映射键名 */
    public $serviceNameMapKey = 'OrderFilterService';

    /**
     * @var int 筛单类别
     * 1 自动筛单(系统根据地址库进行判断,并返回结果,系统无法检索到可派送的将返回不可派送)
     * 2 可人工筛单(系统首先根据地址库判断,如果无法自动判断是否收派,系统将生成需要人工判断的任务,
     * 后续由人工处理,处理结束后,顺丰可主动推送给客户系统)
     */
    public $filterType = 1;
    /** @var string 客户订单号, filter_type=2则必须提供 */
    public $orderId = '';
    /** @var string 到件方详细地址,需要包括省市区 */
    public $dAddress = '';
    /** @var Data_OrderFilterOption|null 订单筛选可选项数据模型 */
    public $orderFilterOption = null;

    public function __construct()
    {
        $this->orderFilterOption = new Data_OrderFilterOption();
    }

    public function getData():?array
    {
        $result = $this->loadPublicParams($this);
        return $result;
    }
}