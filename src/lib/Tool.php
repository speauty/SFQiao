<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Tool.php
 * Created: 2020-04-09 02:06:29
 */
declare(strict_types=1);
namespace SFQiao\lib;


/**
 * Class Tool
 * @package SFQiao\lib
 */
class Tool
{
    /**
     * 生成验证码
     * @param string $xmlStr
     * @param string $checkWord
     * @return string
     */
    static public function getVerifyCode(string $xmlStr, string $checkWord):string
    {
        return base64_encode(md5($xmlStr . $checkWord, true));
    }

    /**
     * 递归创建xml主体内容
     * @param $data
     * @return string
     */
    static public function createXmlRecursion($data): string
    {
        $xml = '';
        foreach ($data as $key => $val) {
            $xmlScope = $key == 'body' ? '' : "<{$key}%s>";
            if (!is_array($val)) {
                return "<{$key}>{$val}</{$key}>";
            }
            if (is_string($key)) {
                $attrStr = '';
                if (isset($val['attributes']) && $val['attributes']) {
                    if (is_array(current($val['attributes']))) {
                        $xml = '';
                        foreach ($val['attributes'] as $v) {
                            $xmlScope = "<{$key}%s></{$key}>";
                            $attrStr = '';
                            foreach ($v as $ak => $av) {
                                $attrStr .= " $ak=\"{$av}\"";
                            }
                            $xmlScope = sprintf($xmlScope, $attrStr);
                            $xml .= $xmlScope;
                        }
                        return $xml;
                    } else {
                        foreach ($val['attributes'] as $ak => $av) {
                            $attrStr .= " $ak=\"{$av}\"";
                        }
                    }
                }
                $xmlScope = sprintf($xmlScope, $attrStr);
            }
            if (isset($val['body']) && $val['body']) {
                foreach ($val['body'] as $bk => $bv) {
                    $xmlScope .= self::createXmlRecursion([$bk => $bv]);
                }
            }
            $xmlScope .= $key == 'body' ? '' : "</{$key}>";
            $xml .= $xmlScope;
        }
        return $xml;
    }

    /**
     * xml字符串转数组
     * @param $xmlStr
     * @return array|null
     */
    static public function convertXml2Arr($xmlStr):?array
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true)?:null;
    }
}