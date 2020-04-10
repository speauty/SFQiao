<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_RouteService.php
 * Created: 2020-04-09 19:46:06
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;


/**
 * Class Data_RouteService
 * @package SFQiao\Lib\Data
 */
class Data_RouteService extends Data
{
    /** @var string 服务映射键名 */
    public $serviceNameMapKey = 'RouteService';
    /**
     * @var int 查询号类别
     * 1 根据顺丰运单号查询,order节点中tracking_number将被当作顺丰运单号处理
     * 2 根据客户订单号查询,order节点中tracking_number将被当作客户订单号处理
     * 3 逆向单,根据客户原始订单号查询,order节点中tracking_number将被当作逆向单原始订单号处理
     */
    public $trackingType = 1;
    /**
     * @var string 查询号
     * 如果tracking_type=1,则此值为顺丰运单号
     * 如果tracking_type=2,则此值为客户订单号
     * 如果tracking_type=3,则此值为逆向单原始订单号
     * 如果有多个单号,以逗号分隔,如"123,124,125"
     */
    public $trackingNumber = '';
    /**
     * @var int 路由查询类别
     * 1 标准路由查询
     */
    public $methodType = 1;
    /** @var string 参考编码(目前针对亚马逊客户,由客户传) */
    public $referenceNumber = '';
    /**
     * @var string 校验电话号码后四位值
     * 按运单号查询路由时,可通过该参数传入用于校验的电话号码后4位(寄方或收方都可以)
     * 如果涉及多个运单号,对应该值也需按顺序传入多个,并以英文逗号隔开
     */
    public $checkPhoneNo = '';

    public function getData():?array
    {
        $result = $this->loadPublicParams($this);
        return $result;
    }
}