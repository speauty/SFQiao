<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Simple.php
 * Created: 2020/3/18 09:58:43
 */
require_once __DIR__.'/../vendor/autoload.php';
use SFQiao\Qiao;

$conf = [
    'customer_code' => 'QC_jMKZZ',
    'check_word' => 'vghrEqtPOygkH8x47lFXSVoyHVvU5OBx',
    'cus_tid' => '7551234567'
];
// 7551234567‬
$result = false;
$qiao = new Qiao($conf);
//$result = $qiao->quickRouteRequest("SF7444404768289");
/**
<?xml version='1.0' encoding='UTF-8'?>
<Response service="RouteService">
<Head>OK</Head>
<Body>
<RouteResponse mailno="SF7444404156506" orderid="T00000001">
<Route remark="顺丰速运 已收取快件（测试数据）" accept_time="2018-05-01 08:01:44" accept_address="广东省深圳市软件产业基地" opcode="50"/>
<Route remark="已签收,感谢使用顺丰,期待再次为您服务（测试数据）" accept_time="2018-05-02 12:01:44" accept_address="广东省深圳市软件产业基地" opcode="80"/>
</RouteResponse>
</Body>
</Response>
 */
//$result = $qiao->quickOrderSearch('T00000003');
//var_dump($result);
//die();
/**
<?xml version='1.0' encoding='UTF-8'?>
<Response service="OrderSearchService">
<Head>OK</Head>
<Body>
<OrderResponse filter_result="2" destcode="755" mailno="SF7444404156506" origincode="755" orderid="T00000001"/>
</Body>
</Response>
 */
/*$result = $qiao->quickOrderFilterService('新疆维吾尔自治区喀什地区喀什市尤木拉克协海尔路11号', [
    'OrderFilterOption' => [
        'j_tel' => '4001118851',
        'j_address' => '广东省深圳市福田区万基商务大厦A座10F',
        'd_tel' => '15818539050',
        'j_custid' => '0123456789',
    ]
]);*/
/**
<?xml version='1.0' encoding='UTF-8'?>
<Response service="OrderFilterService">
<Head>OK</Head>
<Body>
<OrderFilterResponse filter_result="1" orderid="T00000001"/>
</Body>
</Response>
 */

$mustData = [
    'orderid' => 'h4343143123',
    'j_contact' => 'fafdafsd',
    'j_tel' => '15505555525',
    'j_address' => '广东省深圳市福田区新洲十一街万基商务大厦10楼',
    'j_shippercode' => '0000000',
    'j_post_code' => '0000000',
    'd_deliverycode' => '0000000',
    'd_post_code' => '0000000',
    'pay_method' => '1',
    'd_contact' => 'hs',
    'd_tel' => '15555555555',
    'd_address' => '广东省深圳市福田区新洲十一街万基商务大厦10楼',
    'products' => [
        ['name' => '测试商品01', 'count' => 1],
        ['name' => '测试商品01 h 发货的金卡hjfks fsda', 'count' => 1],
        ['name' => 'this is a tes@t', 'count' => 1],
    ]
];
//
$extDat = [];
//$result = $qiao->quickOrderMainland($mustData, $extDat);
//var_dump($result);
//die();
//$result = $qiao->quickOrderCrossBorder($mustData, $extDat);
$extDat = [

];
//$result = $qiao->quickOrderConfirm('g53425245245234', $extDat);
//$result = $qiao->quickGetSubOrderNo('g53425245245234', 5);
$result = $qiao->quickPushOrderState([
    'orderNo' => 'h4343143123',
    'orderStateCode' => '40001',
    'orderStateDesc' => '调度成功,收派员信息',
    'carrierCode' => 'SF'
], [
    'waybillNo' => "SF7444404769390",
    'empCode' => "845215",
    'empPhone' => "13888888888",
    'netCode' => "755A",
    'lastTime' => "2018-04-16 15:23:24",
    'bookTime' => "2018-04-16 15:23:24"
]);
var_dump($result);