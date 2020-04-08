<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Tool.php
 * Created: 2020-04-09 02:06:29
 */
declare(strict_types=1);

namespace SFQiao\Lib;


class Tool
{
    static public function getVerifyCode(string $xml, string $checkWord):string
    {
        return base64_encode(md5($xml . $checkWord, true));
    }

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
}