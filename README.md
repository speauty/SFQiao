#### 顺丰丰桥PHP对接版(全面升级版)
 
 鉴于业务需求(对接顺丰丰桥), 就之前简单Demo重新打包, 并经过一次简单尝试过, 发现模式还有更好的改进, 并且在当前模式上, 也可以有更优的选择. 事后之言.
除此之外, 还有打算封面生成电子面单的想法, 由于时间问题, 只能先暂时放一下. 对了, 顺便说一句, 具体字段名称解释, 请查看源码, 注释齐全, 无后顾之忧.

接下来, 还是简单介绍下, 主要对接的接口:

* 基础实例化
```php
<?php
    require_once __DIR__.'/../vendor/autoload.php';
    use SFQiao\SFQiaoSDK;
    use SFQiao\Lib\Conf;
    $result = false;
    $conf = [
        'customerCode' => '顾客编码',
        'checkWord' => '校验码',
        'cusTid' => '顺丰月结卡号',
        'requestUri' => '请求地址'
    ];
    $conf = (new Conf())->setConfMulti($conf);
    $app = (new SFQiaoSDK())->setConf($conf);
?>
``` 

* 下单结果查询: `quickQueryOrderResult`
```php
<?php
    $data = new \SFQiao\Lib\Data\Data_OrderSearchService();
    $data->orderId = '客户订单号';
    // 也可通过该参数指定查询类型
    $data->searchType = 1;
    $app->quickQueryOrderResult($data);
?>
```

* 快递路由查询: `quickQueryOrderRoute`
```php
<?php
    $data = new \SFQiao\Lib\Data\Data_RouteService();
    $data->trackingNumber = '顺丰运单号/客户订单号/逆向单原始订单号, 根据trackingType属性区分';
    $app->quickQueryOrderRoute($data);
?>
```

* 筛选订单: `quickFilterOrder`
```php
<?php
    $data = new \SFQiao\Lib\Data\Data_OrderFilterService();
    $data->orderId = 'TEST20180410003';
    $data->dAddress = '广东省深圳市南山区学府路软件产业基地1栋B座';
    $app->quickFilterOrder($data);
?>
```

* 生成子单号: `quickApplySubOrderNo`
```php
<?php
    $data = new \SFQiao\Lib\Data\Data_OrderZDService();
    $data->orderId = '客户订单号';
    // 新增包裹数量
    $data->parcelQuantity = 2;
    $app->quickApplySubOrderNo($data);
?>
```

* 确认/取消订单: `quickConfirmOrCancelOrder`
```php
<?php
    $data = new \SFQiao\Lib\Data\Data_OrderConfirmService();
    $data->dealType = 2;
    $data->orderId = '客户订单号';
    // 取消订单正常, 确认订单不太正常
    $app->quickConfirmOrCancelOrder($data);
?>
```

* 下单: `quickOrderMainland`
```php
<?php
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
    
    $app->quickOrderMainland($data);
?>
```

* 下单(跨境件): `quickOrderCrossBorder`
```php
<?php
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
    
    $app->quickOrderCrossBorder($data);
?>
```