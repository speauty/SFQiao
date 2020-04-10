<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    TraitResult.php
 * Created: 2020-04-09 07:07:59
 */
declare(strict_types=1);

namespace SFQiao\Lib\Traits;
use SFQiao\Result;


/**
 * Trait TraitResult
 * @package SFQiao\Lib\Traits
 */
trait TraitResult
{
    protected $result = null;

    public function initResult():void
    {
        $this->result = new Result();
    }

    public function result():?Result
    {
        return $this->result;
    }
}