<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data_OrderZDService.php
 * Created: 2020-04-09 22:45:43
 */
declare(strict_types=1);
namespace SFQiao\Lib\Data;


/**
 * Class Data_OrderZDService
 * @package SFQiao\Lib\Data
 */
class Data_OrderZDService extends Data
{
    /** @var string 服务映射键名 */
    public $serviceNameMapKey = 'OrderZDService';

    /** @var string 客户订单号 */
    public $orderId = '';
    /** @var int 新增加的包裹数,最大20 */
    public $parcelQuantity = 1;

    public function getData(): ?array
    {
        $result = $this->loadPublicParams($this);
        return $result;
    }
}