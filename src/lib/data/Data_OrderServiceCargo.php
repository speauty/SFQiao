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

    public function getData():?array
    {
        return $this->loadOptionParams($this);
    }
}