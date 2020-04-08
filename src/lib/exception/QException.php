<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Qexception.php
 * Created: 2020-04-09 00:35:23
 */
declare(strict_types=1);
namespace SFQiao\lib\exception;
use Throwable;
use \Exception;

/**
 * Class Qexception
 * @package SFQiao\lib\exception
 */
class Qexception extends Exception
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