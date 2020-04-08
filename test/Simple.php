<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Simple.php
 * Created: 2020/3/18 09:58:43
 */
require_once __DIR__.'/../vendor/autoload.php';
use SFQiao\SFQSdk;
use SFQiao\lib\Conf;
use \SFQiao\lib\data\Data_OSS;

$conf = [
    'customerCode' => 'QC_jMKZZ',
    'checkWord' => 'vghrEqtPOygkH8x47lFXSVoyHVvU5OBx',
    'cusTid' => '7551234567'
];
$conf = (new Conf())->setConfMulti($conf);
$data = (new Data_OSS());
$data->orderId = 'T00000001';
$app = new SFQSdk();
$result = $app->setConf($conf)->quickQueryOrderResult($data);
//$result = $app->result()->getResult();
var_dump($result);
die();
