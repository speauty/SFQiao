<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data.php
 * Created: 2020-04-09 01:27:21
 */
declare(strict_types=1);

namespace SFQiao\lib\data;
use SFQiao\lib\ConstSets;
use SFQiao\lib\Tool;
use SFQiao\lib\traits\TraitConf;


/**
 * Class Data
 * @package SFQiao\lib\data
 */
class Data
{
    use TraitConf;
    public $serviceNameMapKey = '';

    public function getData():?array
    {
        return null;
    }

    public function getXmlStr(): string
    {
        $xmlHeader = '<Request service="' . (ConstSets::MAP_SERVICE_NAME[$this->serviceNameMapKey]??'') . '" lang="zh-CN"><Head>' . $this->conf()->customerCode . '</Head><Body>%s</Body></Request>';
        return sprintf($xmlHeader, Tool::createXmlRecursion($this->getData()));
    }
}