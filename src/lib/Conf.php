<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    TraitsConf.phpnf.php
 * Created: 2020-04-09 00:42:09
 */
declare(strict_types=1);
namespace SFQiao\Lib;

use SFQiao\Lib\Exception\QException;

/**
 * Class Conf
 * @package SFQiao\Lib
 */
class Conf
{
    /** @var string 顾客编码 */
    public $customerCode = "";
    /** @var string 校验码 */
    public $checkWord = "";
    /** @var string 顺丰月结卡号 */
    public $cusTid = "";
    /** @var string 请求地址 */
    public $requestUri = ConstSets::REQUEST_URI_DEFAULT;

    public function setConfMulti(array $conf):self
    {
        foreach ($conf as $k => $v) if (property_exists($this, $k) && $v) $this->$k = $v;
        return $this;
    }

    public function validate():void
    {
        $properties = get_object_vars($this);
        if (!$properties) throw New QException("the conf property not set.");
        foreach ($properties as $k => $v) {
            if (!$v) throw New QException("the conf property {$k} is empty.");
        }
    }
}