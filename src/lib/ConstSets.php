<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    ConstSets.php
 * Created: 2020-04-09 00:50:40
 */
declare(strict_types=1);
namespace SFQiao\Lib;


/**
 * Class ConstSets
 * @package SFQiao\Lib
 */
final class ConstSets
{
    /** @var string 默认请求地址 */
    const REQUEST_URI_DEFAULT = 'http://bsp-oisp.sf-express.com/bsp-oisp/sfexpressService';
    const MAP_SERVICE_NAME = [
        /** 下单(中国大陆/国际件) */
        'OrderService' => [
            'serviceName' => 'OrderService',
            'requestBodyRootName' => 'Order'
        ],
        /** 订单结果查询服务 */
        'OrderSearchService' => [
            'serviceName' => 'OrderSearchService',
            'requestBodyRootName' => 'OrderSearch'
        ],
        /**
         * 订单确认/取消服务
         * 客户在确定将货物交付给顺丰托运后,将面单上的一些重要信息,如快件重量通过此接口发送给顺丰
         * 客户在发货前取消订单
         * 订单取消之后,订单号也是不能重复利用的
         */
        'OrderConfirmService' => [
            'serviceName' => 'OrderConfirmService',
            'requestBodyRootName' => 'OrderConfirm'
        ],
        /** 订单筛选服务(客户系统通过此接口向顺丰系统发送主动的筛单请求,用于判断客户的收、派地址是否属于顺丰的收派范围) */
        'OrderFilterService' => [
            'serviceName' => 'OrderFilterService',
            'requestBodyRootName' => 'OrderFilter'
        ],
        /** 路由查询服务(客户可通过此接口查询顺丰运单路由, 系统将返回当前时间点已发生的路由信息) */
        'RouteService' => [
            'serviceName' => 'RouteService',
            'requestBodyRootName' => 'RouteRequest'
        ],
        /** 子单号申请服务(客户在通过下单接口提交订单后,可从此接口获取更多的子运单号) */
        'OrderZDService' => [
            'serviceName' => 'OrderZDService',
            'requestBodyRootName' => 'OrderZD'
        ],
        /** 订单状态推送(仅限于推送预约上门订单调度状态，非预约订单不推送) */
        'PushOrderState' => [
            'serviceName' => 'PushOrderState',
            'requestBodyRootName' => 'OrderConfirm'
        ] ,
        /** 路由推送服务(由顺丰系统发起)(推送方式为增量推送,对于同一个顺丰运单的同一个路由节点,不重复推送) */
        'RoutePushService' => [
            'serviceName' => 'RoutePushService',
            'requestBodyRootName' => 'OrderConfirm'
        ],
    ];

    const MAP_SPECIAL_FIELDS = [
        'orderId' => 'orderid',
        'mailNo' => 'mailno',
        'cusTid' => 'custid',
        'routeLabelService' => 'routelabelService',
        'cargo' => 'Cargo',
        'checkPhoneNo' => 'check_phoneNo',
        'dealType' => 'dealtype',
    ];
}