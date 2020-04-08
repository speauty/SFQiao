<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    QException.php
 * Created: 2020-04-09 00:35:23
 */
declare(strict_types=1);
namespace SFQiao\Lib\Exception;
use Throwable;


/**
 * Class QException
 * @package SFQiao\Lib\Exception
 */
class QException extends \Exception
{
    private $tagPrefix = 'SFQiao';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('['.$this->tagPrefix.']'.$message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->file.'@'.$this->line.':'.$this->message;
    }
}