<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Result.php
 * Created: 2020-04-09 06:54:56
 */
declare(strict_types=1);
namespace SFQiao;
use \GuzzleHttp\Psr7\Response;
use SFQiao\Lib\Tool;


/**
 * Class Result
 * @package SFQiao
 */
class Result
{
    private $result = [
        'state' => false,
        'msg' => '',
        'data' => null
    ];
    private $response = null;
    private $initRequestStr = '';
    private $initResponseStr = '';

    public function response():?Response
    {
        return $this->response;
    }

    public function setResponse(Response $response):Void
    {
        $this->response = $response;
    }

    public function setInitRequest(array $requestData):void
    {
        $this->initRequestStr = http_build_query($requestData);
    }

    /**
     * 获取结果
     * @param bool $withInitInfo 返回数据是否包含原始请求和响应数据
     * @return array
     */
    public function getResult(bool $withInitInfo = false)
    {
        if ($this->response()->getStatusCode() != 200) {
            $this->result['msg'] = $this->response()->getReasonPhrase();
        } else {
            $this->initResponseStr = $this->response()->getBody()->getContents();
            $bodyContent = Tool::convertXml2Arr($this->initResponseStr);
            if (!$bodyContent) {
                $this->result['msg'] = '数据解析异常';
                $this->result['data'] = $this->response()->getBody()->getContents();
            } else {
                if ($bodyContent['Head'] == 'ERR') {
                    $this->result['msg'] = is_array($bodyContent['ERROR']) ? json_encode($bodyContent['ERROR'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $bodyContent['ERROR'];
                } else {
                    $this->result['state'] = true;
                    $this->result['data'] = $bodyContent['Body'] ?? null;
                }
            }
        }
        if ($withInitInfo) {
            $this->result['initRequestStr'] = $this->initRequestStr;
            $this->result['initResponse'] = $this->initResponseStr;
        }
        return $this->result;
    }

    public function getResultSimple(array $result):?array
    {
        $result = null;
        return null;
    }
}