<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderServiceSender.php
 * Created: 2020-04-09 23:19:52
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;


use SFQiao\Lib\Tool;

/**
 * Class Data_OrderServiceSender 下单寄件人数据模型
 * @package SFQiao\Lib\Data
 */
class Data_OrderServiceSender extends Data
{
    /** @var string 寄件方公司名称,如果需要生成电子面单,则为必填 */
    public $jCompany = '';
    /** @var string 寄件方联系人,如果需要生成电子面单,则为必填 */
    public $jContact = '';
    /** @var string 寄件方联系电话,如果需要生成电子面单,则为必填 */
    public $jTel = '';
    /** @var string 寄件方手机 */
    public $jMobile = '';
    /** @var string 寄件方所在省份字段填写要求:必须是标准的省名称称谓 */
    public $jProvince = '';
    /** @var string 寄件方所在城市名称,字段填写要求:必须是标准的城市称谓 */
    public $jCity = '';
    /** @var string 寄件人所在县/区,必须是标准的县/区称谓 */
    public $jCounty = '';
    /** @var string 寄件方详细地址,包括省市区 */
    public $jAddress = '';

    /** @var string 寄方国家 */
    public $jCountry = '';
    /** @var string 寄件方国家/城市代码,如果是跨境件,则此字段为必填 */
    public $jShipperCode = '';
    /** @var string 寄方邮编,跨境件必填(中国大陆,港澳台互寄除外) */
    public $jPostCode = '';

    public function getData():?array
    {
        return $this->loadOptionParams($this);
    }
}