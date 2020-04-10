<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderServiceReceiver.php
 * Created: 2020-04-09 23:28:21
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;


use SFQiao\Lib\Tool;

/**
 * Class Data_OrderServiceReceiver 下单收件人数据模型
 * @package SFQiao\Lib\Data
 */
class Data_OrderServiceReceiver extends Data
{
    /** @var string 到件方公司名称 */
    public $dCompany = '';
    /** @var string 到件方联系人 */
    public $dContact = '';
    /** @var string 到件方联系电话 */
    public $dTel = '';
    /** @var string 到件方手机 */
    public $dMobile = '';
    /** @var string 到件方所在省份,必须是标准的省名称称谓 */
    public $dProvince = '';
    /** @var string 到件方所在城市名称,必须是标准的城市称谓 */
    public $dCity = '';
    /** @var string 到件方所在县/区,必须是标准的县/区称谓 */
    public $dCounty = '';
    /**
     * @var string 到件方详细地址
     * 如果不传输d_province/d_city字段,此详细地址需包含省市信息,以提高地址识别的成功率
     */
    public $dAddress = '';

    /**
     * @var string 到件方代码
     * 如果是跨境件,则要传这个字段,用于表示到方国家的城市
     * 如果此国家整体是以代理商来提供服务的,则此字段可能需要传国家编码
     * 具体商务沟通中双方约定
     */
    public $dDeliveryCode = '';
    /** @var string 到方国家 */
    public $dCountry = '';
    /** @var string 到方邮编,跨境件必填(中国大陆,港澳台互寄除外) */
    public $dPostCode = '';

    public function getData():?array
    {
        return $this->loadOptionParams($this);
    }
}