<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderConfirmOption.php
 * Created: 2020-04-09 22:59:04
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;


use SFQiao\Lib\Tool;

/**
 * Class Data_OrderConfirmOption 订单确认可选参数数据模型
 * @package SFQiao\Lib\Data
 */
class Data_OrderConfirmOption extends Data
{
    /**
     * @var int 订单货物总重量
     * 包含子母件,单位千克,精确到小数点后2位,如果提供此值,必须>0
     */
    public $weight = 0;
    /**
     * @var string 货物的总体积
     (值为 长,宽,高),包含 子母件,以半角逗号,分隔,单位厘米,精确到小数点后2位,会用于计抛(是否计 抛具体商务沟通中双 方约定)
     */
    public $volume = '';
    /** @var string 顺丰签回单服务运单号 */
    public $returnTracking = '';
    /** @var string 快件产品类别 */
    public $expressType = '';
    /** @var string 子单号(以半角逗号,分隔)如果此字段为 空,以下订单时为准 */
    public $childrenNos = '';
    /** @var int 电子面单图片规格 1 A4 2 A5*/
    public $waybillSize = 1;
    /** @var int 是否生成电子面单图片 */
    public $isGenEletricPic = 0;

    public function getData(): ?array
    {
        return $this->loadOptionParams($this);
    }
}