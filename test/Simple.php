<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Simple.php
 * Created: 2020/3/18 09:58:43
 */
require_once __DIR__.'/../vendor/autoload.php';
use SFQiao\SFQiaoSDK;
use SFQiao\Lib\Conf;
$result = false;
$conf = [
    'customerCode' => 'QC_jMKZZ',
    'checkWord' => 'vghrEqtPOygkH8x47lFXSVoyHVvU5OBx',
    'cusTid' => '7551234567'
];
$conf = (new Conf())->setConfMulti($conf);
$data = new \SFQiao\Lib\Data\Data_OrderSearchService();
$data->orderId = 'TEST20180410003';
$app = new SFQiaoSDK();
//$result = $app->setConf($conf)->quickQueryOrderResult($data);
//var_dump($result);
//die();
//     string(15) "SF7444404841309"
//    ["origincode"]=>
//    string(3) "755"
//    ["orderid"]=>
//    string(15) "TEST20180410003"
$data = new \SFQiao\Lib\Data\Data_RouteService();
$data->trackingNumber = 'SF7444404841309';

//$result = $app->setConf($conf)->quickQueryOrderRoute($data);
//var_dump($result);
//die();

$data = new \SFQiao\Lib\Data\Data_OrderFilterService();
$data->orderId = 'TEST20180410003';
$data->dAddress = '广东省深圳市南山区学府路软件产业基地1栋B座';
//$result = $app->setConf($conf)->quickFilterOrder($data);
//var_dump($result);
//die();
$data = new \SFQiao\Lib\Data\Data_OrderZDService();
$data->orderId = 'TEST20180410002';
$data->parcelQuantity = 2;
//$result = $app->setConf($conf)->quickApplySubOrderNo($data);
//var_dump($result);
//die();
$data = new \SFQiao\Lib\Data\Data_OrderConfirmService();
$data->dealType = 1;
$data->orderId = 'TEST20180410009';
$data->mailNo = 'SF7444404842163';
$data->orderConfirmOption->weight = 22;
// 确认异常
//$result = $app->setConf($conf)->quickConfirmOrCancelOrder($data);
//var_dump($result);
//die();
$data = new \SFQiao\Lib\Data\Data_OrderService();
$data->orderId = 'TEST20180410009';
$data->expressType = '1';
$data->sender->jProvince = '广东省';
$data->sender->jCity = '深圳市';
$data->sender->jCounty = '福田区';
$data->sender->jCompany = '顺丰速运';
$data->sender->jContact = '小丰';
$data->sender->jTel = '95338';
$data->sender->jTel = '95338';
$data->sender->jAddress = '新洲十一街万基商务大厦';
$data->receiver->dProvince = '广东省';
$data->receiver->dCity = '深圳市';
$data->receiver->dCounty = '南山区';
$data->receiver->dCompany = '顺丰科技';
$data->receiver->dContact = '小顺';
$data->receiver->dTel = '4008111111';
$data->receiver->dAddress = '学府路软件产业基地1栋B座';
$data->receiver->dCounty = '南山区';
$data->receiver->dCounty = '南山区';
$data->receiver->dCounty = '南山区';
$data->parcelQuantity = 1;
$data->cargoTotalWeight = 1;
$data->cusTid = '7551234567';
$data->payMethod = 1;
$data->routeLabelService = 1;
$news = $data->cargo();
$news->name = '手机';
$newsB = $data->cargo();
$newsB->name = '哈拉';
$data->cargoArr = [$news, $newsB];

//$result = $app->setConf($conf)->quickOrderMainland($data);
//var_dump($result);
//die();

$data = new \SFQiao\Lib\Data\Data_OrderServiceCrossBorder();
$data->orderId = 'QIAO-KA20171231003';
$data->sender->jProvince = 'Singapore';
$data->sender->jCity = 'Singapore';
$data->sender->jCounty = 'Singapore';
$data->sender->jCompany = 'SFSingapore';
$data->sender->jContact = 'PeterK';
$data->sender->jTel = '12345678';
$data->sender->jShipperCode = 'SIN01D';
$data->sender->jPostCode = '628105';
$data->sender->jCountry = 'SG';
$data->sender->jAddress = '7SixthLokYangRoad#11-11Singapore628105';
$data->receiver->dDeliveryCode = '852';
$data->receiver->dPostCode = '852852';
$data->receiver->dCountry = 'HK';
$data->receiver->dProvince = 'Hong Kong';
$data->receiver->dCity = 'Hong Kong';
$data->receiver->dCounty = 'Hong Kong';
$data->receiver->dCompany = 'Daniel';
$data->receiver->dContact = 'DanielLi';
$data->receiver->dTel = '87654321';
$data->receiver->dAddress = '27/Ftestaddress,Kowloon,HongKong';
$data->parcelQuantity = 1;
$data->cargoTotalWeight = 1;
$data->cusTid = '7551234567';
$data->payMethod = 1;
$data->expressType = 1;
$data->declaredValue = '1';
$data->declaredValueCurrency = 'CNY';
$news = $data->cargo();
$news->name = 'nailcare';
$news->count = '20';
$news->unit = 'pcs';
$news->weight = '0.003';
$news->amount = '0.05';
$news->currency = 'CNY';
$news->sourceArea = 'CN';
$data->cargoArr = [$news];

$result = $app->setConf($conf)->quickOrderCrossBorder($data);
var_dump($result);
die();
