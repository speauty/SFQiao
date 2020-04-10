<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Data.php
 * Created: 2020-04-09 01:27:21
 */
declare(strict_types=1);

namespace SFQiao\Lib\Data;
use SFQiao\Lib\ConstSets;
use SFQiao\Lib\Tool;
use SFQiao\Lib\Traits\TraitConf;


/**
 * Class Data
 * @package SFQiao\Lib\Data
 */
class Data
{
    use TraitConf;
    protected $serviceNameMapKey = '';
    private $ignoreKeyArr = [
        'conf', 'ignoreKeyArr', 'serviceNameMapKey'
    ];

    protected function loadOptionParams(Data $obj):?array
    {
        $properties = array_filter(get_object_vars($obj));
        $newData = [];
        foreach ($properties as $k => $v) {
            if (in_array($k, $this->ignoreKeyArr)) continue;
            $newData[Tool::getRealName($k)] = $v;
        }
        return $newData;
    }

    public function loadPublicParams(Data $obj, string $rootName = ''):?array
    {
        $rootName = $this->getServiceName('requestBodyRootName');
        $data = [
            $rootName => [
                'attributes' => null,
                'body' => null
            ]
        ];
        $properties = get_object_vars($obj);
        $properties = array_filter($properties);
        foreach ($properties as $k => $v) {
            if (in_array($k, $this->ignoreKeyArr)) continue;
            $keyRealName = Tool::getRealName($k);
            if (is_string($v) || is_integer($v)) {
                $data[$rootName]['attributes'][$keyRealName] = $v;
            } else if (is_object($v)) {
                if (is_object($v) && method_exists($v, 'getData')) {
                    $tmp = $v->getData();
                    if ($tmp) $data[$rootName]['attributes'] = array_merge($data[$rootName]['attributes'], $tmp);
                }
            } else if (is_array($v)) {
                $tmpArr = [];
                foreach ($v as $sk => $sv) {
                    if (is_object($sv) && method_exists($sv, 'getData')) {
                        $tmpArr[] = $sv->getData();
                    }
                }
                $data[$rootName]['body'][Tool::getRealName(substr($k, 0, -3))] = [
                    'attributes' => $tmpArr
                ];
            }
        }
        return $data;
    }

    final public function getServiceName(string $idxName, string $mapName = ''):string
    {
        return ConstSets::MAP_SERVICE_NAME[$mapName?:$this->serviceNameMapKey][$idxName]??'';
    }

    final public function getXmlStr(): string
    {
        $xmlHeader = '<Request service="' . $this->getServiceName('serviceName') . '" lang="zh-CN"><Head>' . $this->conf()->customerCode . '</Head><Body>%s</Body></Request>';
        return sprintf($xmlHeader, Tool::createXmlRecursion($this->getData()));
    }


}