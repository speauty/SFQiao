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
    'cus_tid' => '7551234567‬'
];
// 7551234567‬
$result = false;
$qiao = new Qiao($conf);
//$result = $qiao->quickRouteRequest('SF7444404156506');
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
//$result = $qiao->quickOrderSearch('T00000001');
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
    'orderid' => 'T00000004',
    'j_contact' => 'speauty',
    'j_tel' => '15555555555',
    'j_address' => '广东省深圳市福田区新洲十一街万基商务大厦10楼',
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
/**
<?xml version='1.0' encoding='UTF-8'?>
<Response service="OrderService">
<Head>OK</Head>
<Body>
<OrderResponse filter_result="2" destcode="755" mailno="SF7444404156506" origincode="755" orderid="T00000001">
<rls_info rls_errormsg="SF7444404156506:" invoke_result="OK" rls_code="1000">
<rls_detail waybillNo="SF7444404156506" sourceCityCode="755" destCityCode="755" destDeptCode="755BF" destTeamCode="018" destTransferCode="755W" destRouteLabel="755W-755BF" proName="顺丰标快" cargoTypeCode="C201" limitTypeCode="T4" expressTypeCode="B1" codingMapping="D18" xbFlag="0" printFlag="000000000" twoDimensionCode="MMM={'k1':'755W','k2':'755BF','k3':'018','k4':'T4','k5':'SF7444404156506','k6':'','k7':'39bb4bd9'}" proCode="T4" printIcon="00000000" checkCode="39bb4bd9" destGisDeptCode="755BF"/>
</rls_info>
</OrderResponse>
</Body>
</Response>
 */
//$result = $qiao->quickOrderCancel('T00000003');
/**
<?xml version='1.0' encoding='UTF-8'?>
<Response service="OrderConfirmService">
<Head>OK</Head>
<Body>
<OrderConfirmResponse res_status="2" orderid="T00000001"/>
</Body>
</Response>
 */
$result = $qiao->quickOrderCrossBorder($mustData, $extDat);
var_dump($result);