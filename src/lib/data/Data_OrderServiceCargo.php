<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderServiceCargo.php
 * Created: 2020-04-09 23:44:36
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;


use SFQiao\Lib\Tool;

/**
 * Class Data_OrderServiceCargo
 * 下单产品数据模型
 * @package SFQiao\Lib\Data
 */
class Data_OrderServiceCargo extends Data
{
    /** @var string 货物名称,如果需要生成电子面单,则为必填 */
    public $name = '';
    /** @var int 货物数量 跨境件报关需要填写 */
    public $count = 0;
    /** @var string 货物单位 跨境件报关需要填写 */
    public $unit = '';
    /**
     * @var int 订单货物单位重量
     * 包含子母件,单位千克,精确到小数点后6位跨境件报关需要填写
     */
    public $weight = 0;
    /**
     * @var int 货物单价
     * 精确到小数点后10位,跨境件报关需要填写
     */
    public $amount = 0;
    /** @var string 货物单价的币别 */
    public $currency = '';
    /** @var string 原产地国别,跨境件报关需要填写 */
    public $sourceArea = '';
    /** @var string 货物产品国检备案编号 */
    public $productRecordNo = '';
    /** @var string 商品海关备案号 */
    public $goodPrepardNo = '';
    /** @var string 商品行邮税号 */
    public $taxNo = '';
    /** @var string 海关编码 */
    public $hsCode = '';

    public function getData():?array
    {
        return $this->loadOptionParams($this);
    }
}